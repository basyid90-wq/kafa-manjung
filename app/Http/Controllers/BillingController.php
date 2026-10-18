<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\Bayarcash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

/**
 * Monthly plan purchase through Bayarcash.
 * The plan is only activated from a checksum-verified gateway message (callback or return URL),
 * never from anything the browser posts.
 */
class BillingController extends Controller
{
    public function __construct(private Bayarcash $bayarcash)
    {
    }

    /** Workspace owner starts a one-month payment for a plan allowed for the workspace type. */
    public function checkout(Request $request)
    {
        $user   = $request->user();
        $school = $user->school;
        abort_unless($school && $user->hasRole('Guru Besar'), 403, 'Hanya pemilik akaun boleh membuat pembayaran.');

        $allowed = collect(config("plans.types.{$school->type}.plans"))
            ->filter(fn ($p) => (config("plans.plans.{$p}.price") ?? 0) > 0)
            ->values()->all();

        $data = $request->validate([
            'plan' => ['required', Rule::in($allowed)],
        ], [
            'plan.in' => 'Pakej ini tidak tersedia untuk jenis akaun anda.',
        ]);

        if (!$this->bayarcash->isConfigured()) {
            return redirect()->route('subscription.index')
                ->with('error', 'Pembayaran dalam talian belum diaktifkan. Sila hubungi kami.');
        }

        $payment = Payment::create([
            'school_id'    => $school->id,
            'user_id'      => $user->id,
            'plan'         => $data['plan'],
            'months'       => 1,
            'amount'       => config("plans.plans.{$data['plan']}.price"),
            'order_number' => Payment::newOrderNumber(),
        ]);

        try {
            $intent = $this->bayarcash->createPaymentIntent($payment, $user);
        } catch (\Throwable $e) {
            Log::error('Bayarcash payment intent failed', ['order' => $payment->order_number, 'error' => $e->getMessage()]);
            $payment->markUnsuccessful('failed', ['status_description' => mb_substr($e->getMessage(), 0, 255)]);

            return redirect()->route('subscription.index')
                ->with('error', 'Gagal menyambung ke gerbang pembayaran. Sila cuba sebentar lagi.');
        }

        $payment->forceFill(['gateway_intent_id' => $intent['id']])->save();

        return redirect()->away($intent['url']);
    }

    /** Payer's browser comes back here after paying (GET from Bayarcash). */
    public function return(Request $request)
    {
        $data = $request->all();

        if (!$this->bayarcash->verifyReturnUrl($data)) {
            Log::warning('Bayarcash return checksum mismatch', ['order' => $data['order_number'] ?? null]);
            return redirect()->route('subscription.index')->with('error', 'Maklumat pembayaran tidak dapat disahkan.');
        }

        $payment = $this->applyGatewayResult($data);
        $paid    = $payment?->status === 'paid';

        return redirect()->route('subscription.index')->with(
            $paid ? 'success' : 'error',
            $paid
                ? 'Pembayaran berjaya. Pakej ' . config("plans.plans.{$payment->plan}.label") . ' aktif hingga ' . $payment->period_end->format('d/m/Y') . '.'
                : 'Pembayaran tidak berjaya' . (!empty($data['status_description']) ? ': ' . $data['status_description'] : '.')
        );
    }

    /** Server-to-server notification from Bayarcash (POST, CSRF-exempt). */
    public function callback(Request $request)
    {
        $data = $request->all();

        if (($data['record_type'] ?? null) === 'pre_transaction') {
            abort_unless($this->bayarcash->verifyPreTransactionCallback($data), 403);
            return response('OK');
        }

        if (!$this->bayarcash->verifyTransactionCallback($data)) {
            Log::warning('Bayarcash callback checksum mismatch', ['order' => $data['order_number'] ?? null]);
            abort(403);
        }

        $this->applyGatewayResult($data);

        return response('OK');
    }

    private function applyGatewayResult(array $data): ?Payment
    {
        $payment = Payment::findByOrderNumber($data['order_number'] ?? null);
        if (!$payment) {
            Log::warning('Bayarcash result for unknown order', ['order' => $data['order_number'] ?? null]);
            return null;
        }

        $gateway = array_filter([
            'transaction_id'            => $data['transaction_id'] ?? null,
            'exchange_reference_number' => $data['exchange_reference_number'] ?? null,
            'payer_bank_name'           => $data['payer_bank_name'] ?? null,
            'status_description'        => isset($data['status_description']) ? mb_substr($data['status_description'], 0, 255) : null,
        ], fn ($v) => $v !== null);

        $status = (int) ($data['status'] ?? -1);

        if ($status === Bayarcash::STATUS_SUCCESS) {
            // Defence in depth: the paid amount must match what we asked for
            if ((int) round(((float) ($data['amount'] ?? 0)) * 100) !== (int) round(((float) $payment->amount) * 100)) {
                Log::error('Bayarcash amount mismatch', ['order' => $payment->order_number, 'amount' => $data['amount'] ?? null]);
                $payment->markUnsuccessful('failed', ['status_description' => 'Jumlah bayaran tidak sepadan']);
                return $payment;
            }
            $payment->markPaid($gateway);
        } elseif ($status === Bayarcash::STATUS_FAILED) {
            $payment->markUnsuccessful('failed', $gateway);
        } elseif ($status === Bayarcash::STATUS_CANCELLED) {
            $payment->markUnsuccessful('cancelled', $gateway);
        }

        return $payment->refresh();
    }
}

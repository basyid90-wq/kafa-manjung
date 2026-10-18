<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Minimal Bayarcash v3 client (mirrors webimpian/bayarcash-php-sdk without adding the package).
 * Checksums: fields sorted by key, values joined with "|", HMAC-SHA256 with the API secret key.
 */
class Bayarcash
{
    public const STATUS_NEW       = 0;
    public const STATUS_PENDING   = 1;
    public const STATUS_FAILED    = 2;
    public const STATUS_SUCCESS   = 3;
    public const STATUS_CANCELLED = 4;

    public function isConfigured(): bool
    {
        return filled(config('services.bayarcash.api_token'))
            && filled(config('services.bayarcash.secret_key'))
            && filled(config('services.bayarcash.portal_key'));
    }

    /** Create a payment intent and return the hosted payment page URL. */
    public function createPaymentIntent(Payment $payment, User $payer): array
    {
        if (!$this->isConfigured()) {
            throw new RuntimeException('Bayarcash belum dikonfigurasi.');
        }

        $data = [
            'payment_channel'        => config('services.bayarcash.payment_channel'),
            'portal_key'             => config('services.bayarcash.portal_key'),
            'order_number'           => $payment->order_number,
            'amount'                 => $payment->amountString(),
            'payer_name'             => $payer->name,
            'payer_email'            => $payer->email,
            'payer_telephone_number' => $payer->phone ?: null,
            'return_url'             => route('billing.return'),
            'callback_url'           => route('billing.callback'),
        ];
        $data['checksum'] = $this->paymentIntentChecksum($data);

        $response = Http::withToken(config('services.bayarcash.api_token'))
            ->acceptJson()
            ->withHeaders(['Idempotency-Key' => $payment->order_number])
            ->timeout(20)
            ->post(config('services.bayarcash.base_url') . 'payment-intents', array_filter($data, fn ($v) => $v !== null));

        if (!$response->successful() || !$response->json('url')) {
            throw new RuntimeException('Bayarcash: ' . ($response->json('message') ?? 'HTTP ' . $response->status()));
        }

        return ['id' => $response->json('id'), 'url' => $response->json('url')];
    }

    public function paymentIntentChecksum(array $data): string
    {
        return $this->sign([
            'payment_channel' => $data['payment_channel'] ?? null,
            'order_number'    => $data['order_number'] ?? null,
            'amount'          => $data['amount'] ?? null,
            'payer_name'      => $data['payer_name'] ?? null,
            'payer_email'     => $data['payer_email'] ?? null,
        ]);
    }

    public function verifyTransactionCallback(array $d): bool
    {
        return $this->matches($d, [
            'record_type', 'transaction_id', 'exchange_reference_number', 'exchange_transaction_id',
            'order_number', 'currency', 'amount', 'payer_name', 'payer_email', 'payer_bank_name',
            'status', 'status_description', 'datetime',
        ]);
    }

    public function verifyPreTransactionCallback(array $d): bool
    {
        return $this->matches($d, ['record_type', 'exchange_reference_number', 'order_number']);
    }

    public function verifyReturnUrl(array $d): bool
    {
        return $this->matches($d, [
            'transaction_id', 'exchange_reference_number', 'exchange_transaction_id', 'order_number',
            'currency', 'amount', 'payer_bank_name', 'status', 'status_description',
        ]);
    }

    private function matches(array $data, array $fields): bool
    {
        $payload = [];
        foreach ($fields as $field) {
            $payload[$field] = $data[$field] ?? null;
        }

        return hash_equals($this->sign($payload), (string) ($data['checksum'] ?? ''));
    }

    private function sign(array $payload): string
    {
        ksort($payload);

        return hash_hmac('sha256', implode('|', $payload), (string) config('services.bayarcash.secret_key'));
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Payment extends Model
{
    use BelongsToSchool;

    protected $fillable = ['school_id', 'user_id', 'plan', 'months', 'amount', 'order_number'];

    protected $casts = [
        'amount'       => 'decimal:2',
        'paid_at'      => 'datetime',
        'period_start' => 'datetime',
        'period_end'   => 'datetime',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function newOrderNumber(): string
    {
        return 'EK' . now()->format('ymd') . strtoupper(Str::random(8));
    }

    /** Amount as sent to / echoed by the gateway, e.g. "19.00". */
    public function amountString(): string
    {
        return number_format((float) $this->amount, 2, '.', '');
    }

    /** Look up by order number regardless of who is logged in (gateway callbacks are anonymous). */
    public static function findByOrderNumber(?string $orderNumber): ?self
    {
        return $orderNumber
            ? static::withoutGlobalScope('school')->where('order_number', $orderNumber)->first()
            : null;
    }

    /**
     * Mark paid and extend the school's plan. Idempotent: callback and return URL may both arrive.
     * A renewal of the same, still-active plan extends from the current expiry; otherwise from now.
     */
    public function markPaid(array $gateway = []): void
    {
        DB::transaction(function () use ($gateway) {
            $payment = static::withoutGlobalScope('school')->lockForUpdate()->find($this->id);
            if ($payment->status === 'paid') {
                return;
            }

            $school = School::lockForUpdate()->find($payment->school_id);

            $start = now();
            if ($school->plan === $payment->plan && $school->plan_expires_at && $school->plan_expires_at->isFuture()) {
                $start = $school->plan_expires_at->copy();
            }
            $end = $start->copy()->addMonthsNoOverflow($payment->months);

            $school->forceFill(['plan' => $payment->plan, 'plan_expires_at' => $end])->save();

            $payment->forceFill(array_merge($gateway, [
                'status'       => 'paid',
                'paid_at'      => now(),
                'period_start' => $start,
                'period_end'   => $end,
            ]))->save();

            $this->setRawAttributes($payment->getAttributes(), true);
        });
    }

    public function markUnsuccessful(string $status, array $gateway = []): void
    {
        if ($this->status === 'paid') {
            return; // never downgrade a confirmed payment
        }

        $this->forceFill(array_merge($gateway, ['status' => $status]))->save();
    }

    public function statusLabel(): string
    {
        return [
            'pending'   => 'Menunggu',
            'paid'      => 'Berjaya',
            'failed'    => 'Gagal',
            'cancelled' => 'Dibatalkan',
        ][$this->status] ?? $this->status;
    }
}

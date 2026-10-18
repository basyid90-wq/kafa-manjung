<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\School;
use App\Models\User;
use App\Notifications\PlanExpiringNotification;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request as HttpRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class BillingTest extends TestCase
{
    use RefreshDatabase;

    private const SECRET = 'test-secret-key';

    private School $school;
    private User $owner;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);

        config([
            'services.bayarcash.api_token'       => 'test-token',
            'services.bayarcash.secret_key'      => self::SECRET,
            'services.bayarcash.portal_key'      => 'test-portal',
            'services.bayarcash.payment_channel' => 1,
            'services.bayarcash.base_url'        => 'https://bayarcash.test/v3/',
        ]);

        $this->school = School::factory()->create();
        $this->school->forceFill(['type' => 'sekolah', 'plan' => 'free'])->save();
        $this->owner = User::factory()->create(['school_id' => $this->school->id, 'phone' => '0123456789']);
        $this->owner->assignRole('Guru Besar');
        $this->school->forceFill(['owner_id' => $this->owner->id])->save();
    }

    private function sign(array $payload): string
    {
        ksort($payload);

        return hash_hmac('sha256', implode('|', $payload), self::SECRET);
    }

    private function pendingPayment(string $plan = 'sekolah', string $amount = '49.00'): Payment
    {
        return Payment::withoutGlobalScopes()->forceCreate([
            'school_id' => $this->school->id, 'user_id' => $this->owner->id, 'plan' => $plan,
            'months' => 1, 'amount' => $amount, 'order_number' => Payment::newOrderNumber(), 'status' => 'pending',
        ]);
    }

    private function callbackData(Payment $payment, int $status = 3, ?string $amount = null): array
    {
        $data = [
            'record_type' => 'transaction', 'transaction_id' => 'trx_123', 'exchange_reference_number' => '1-ABC',
            'exchange_transaction_id' => 'FPX123', 'order_number' => $payment->order_number, 'currency' => 'MYR',
            'amount' => $amount ?? $payment->amountString(), 'payer_name' => $this->owner->name,
            'payer_email' => $this->owner->email, 'payer_bank_name' => 'Maybank2u', 'status' => (string) $status,
            'status_description' => $status === 3 ? 'Approved' : 'Failed', 'datetime' => now()->toDateTimeString(),
        ];
        $data['checksum'] = $this->sign($data);

        return $data;
    }

    public function test_checkout_creates_payment_intent_with_valid_checksum(): void
    {
        Http::fake(['bayarcash.test/*' => Http::response(['id' => 'pi_1', 'url' => 'https://pay.bayarcash.test/pi_1'])]);

        $this->actingAs($this->owner)
            ->post(route('billing.checkout'), ['plan' => 'sekolah'])
            ->assertRedirect('https://pay.bayarcash.test/pi_1');

        $payment = Payment::withoutGlobalScopes()->first();
        $this->assertSame('pending', $payment->status);
        $this->assertSame('49.00', $payment->amountString());
        $this->assertSame('pi_1', $payment->gateway_intent_id);

        Http::assertSent(function (HttpRequest $req) use ($payment) {
            $expected = $this->sign([
                'payment_channel' => 1, 'order_number' => $payment->order_number, 'amount' => '49.00',
                'payer_name' => $this->owner->name, 'payer_email' => $this->owner->email,
            ]);

            return $req->url() === 'https://bayarcash.test/v3/payment-intents'
                && $req->hasHeader('Authorization', 'Bearer test-token')
                && $req['portal_key'] === 'test-portal'
                && $req['checksum'] === $expected;
        });
    }

    public function test_checkout_is_disabled_until_bayarcash_is_configured(): void
    {
        config(['services.bayarcash.api_token' => null]);

        $this->actingAs($this->owner)
            ->post(route('billing.checkout'), ['plan' => 'sekolah'])
            ->assertRedirect(route('subscription.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseCount('payments', 0);
    }

    public function test_only_the_owner_can_pay(): void
    {
        $teacher = User::factory()->create(['school_id' => $this->school->id]);
        $teacher->assignRole('Guru KAFA');

        $this->actingAs($teacher)->post(route('billing.checkout'), ['plan' => 'sekolah'])->assertForbidden();
    }

    public function test_personal_workspace_cannot_buy_sekolah_plan(): void
    {
        $this->school->forceFill(['type' => 'personal'])->save();

        $this->actingAs($this->owner)
            ->post(route('billing.checkout'), ['plan' => 'sekolah'])
            ->assertSessionHasErrors('plan');
    }

    public function test_successful_callback_activates_plan_once(): void
    {
        $payment = $this->pendingPayment();
        $data = $this->callbackData($payment);

        $this->post(route('billing.callback'), $data)->assertOk();
        $this->post(route('billing.callback'), $data)->assertOk(); // retries must not extend twice

        $school = $this->school->fresh();
        $this->assertSame('sekolah', $school->plan);
        $this->assertTrue($school->plan_expires_at->isSameDay(now()->addMonthNoOverflow()));
        $this->assertSame('paid', $payment->fresh()->status);
        $this->assertSame('Maybank2u', $payment->fresh()->payer_bank_name);
    }

    public function test_tampered_callback_is_rejected(): void
    {
        $payment = $this->pendingPayment();
        $data = $this->callbackData($payment);
        $data['amount'] = '1.00'; // changed after signing

        $this->post(route('billing.callback'), $data)->assertForbidden();

        $this->assertSame('free', $this->school->fresh()->plan);
        $this->assertSame('pending', $payment->fresh()->status);
    }

    public function test_signed_callback_with_wrong_amount_does_not_activate(): void
    {
        $payment = $this->pendingPayment();

        $this->post(route('billing.callback'), $this->callbackData($payment, 3, '1.00'))->assertOk();

        $this->assertSame('free', $this->school->fresh()->plan);
        $this->assertSame('failed', $payment->fresh()->status);
    }

    public function test_failed_payment_leaves_plan_unchanged(): void
    {
        $payment = $this->pendingPayment();

        $this->post(route('billing.callback'), $this->callbackData($payment, 2))->assertOk();

        $this->assertSame('free', $this->school->fresh()->plan);
        $this->assertSame('failed', $payment->fresh()->status);
    }

    public function test_renewal_extends_from_current_expiry(): void
    {
        $expiry = now()->addDays(10)->startOfSecond();
        $this->school->forceFill(['plan' => 'sekolah', 'plan_expires_at' => $expiry])->save();
        $payment = $this->pendingPayment();

        $this->post(route('billing.callback'), $this->callbackData($payment))->assertOk();

        $this->assertTrue($this->school->fresh()->plan_expires_at->equalTo($expiry->copy()->addMonthNoOverflow()));
    }

    public function test_return_url_with_valid_checksum_activates_plan(): void
    {
        $payment = $this->pendingPayment();
        $data = [
            'transaction_id' => 'trx_9', 'exchange_reference_number' => '1-XYZ', 'exchange_transaction_id' => 'FPX9',
            'order_number' => $payment->order_number, 'currency' => 'MYR', 'amount' => '49.00',
            'payer_bank_name' => 'CIMB Clicks', 'status' => '3', 'status_description' => 'Approved',
        ];
        $data['checksum'] = $this->sign($data);

        $this->actingAs($this->owner)
            ->get(route('billing.return', $data))
            ->assertRedirect(route('subscription.index'))
            ->assertSessionHas('success');

        $this->assertSame('sekolah', $this->school->fresh()->effectivePlan());
    }

    public function test_expiry_reminder_is_sent_to_owner(): void
    {
        Notification::fake();
        $this->school->forceFill(['plan' => 'sekolah', 'plan_expires_at' => now()->addDays(7)])->save();

        $this->artisan('plans:remind')->assertSuccessful();

        Notification::assertSentTo($this->owner, PlanExpiringNotification::class);
    }
}

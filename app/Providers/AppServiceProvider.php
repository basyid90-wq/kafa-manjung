<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.flowbite');
        Paginator::defaultSimpleView('vendor.pagination.flowbite-simple');

        // Auth e-mails in Bahasa Melayu
        VerifyEmail::toMailUsing(fn ($notifiable, string $url) => (new MailMessage)
            ->subject('Sahkan alamat e-mel anda — eKafa Online')
            ->greeting('Assalamualaikum ' . $notifiable->name . ',')
            ->line('Terima kasih kerana mendaftar dengan eKafa Online. Sila sahkan alamat e-mel anda untuk mula menggunakan sistem.')
            ->action('Sahkan E-mel', $url)
            ->line('Jika anda tidak mendaftar akaun, abaikan e-mel ini.')
            ->salutation('Salam hormat, Pasukan eKafa Online'));

        ResetPassword::toMailUsing(fn ($notifiable, string $token) => (new MailMessage)
            ->subject('Set semula kata laluan — eKafa Online')
            ->greeting('Assalamualaikum ' . $notifiable->name . ',')
            ->line('Kami menerima permintaan untuk menetapkan semula kata laluan akaun anda.')
            ->action('Set Semula Kata Laluan', url(route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
            ->line('Pautan ini sah selama ' . config('auth.passwords.users.expire') . ' minit. Jika anda tidak membuat permintaan ini, abaikan e-mel ini.')
            ->salutation('Salam hormat, Pasukan eKafa Online'));

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}

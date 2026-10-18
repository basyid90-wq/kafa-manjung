<?php

namespace App\Notifications;

use App\Models\School;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PlanExpiringNotification extends Notification
{
    public function __construct(public School $school, public int $daysLeft)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $plan = $this->school->planLabel();
        $date = $this->school->plan_expires_at->format('d/m/Y');

        return (new MailMessage)
            ->subject("Pakej {$plan} anda tamat dalam {$this->daysLeft} hari — eKafa Online")
            ->greeting('Assalamualaikum ' . $notifiable->name . ',')
            ->line("Pakej {$plan} untuk {$this->school->name} akan tamat pada {$date}.")
            ->line('Selepas tamat, akaun akan kembali ke pakej Percuma. Data anda kekal, tetapi modul berbayar akan dikunci.')
            ->action('Lanjutkan Langganan', route('subscription.index'))
            ->salutation('Salam hormat, Pasukan eKafa Online');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => "Pakej {$this->school->planLabel()} tamat dalam {$this->daysLeft} hari",
            'url'   => route('subscription.index'),
        ];
    }
}

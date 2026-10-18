<?php

namespace App\Notifications;

use App\Models\Invitation;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeacherInvitation extends Notification
{
    public function __construct(public Invitation $invitation, public string $token)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $school  = $this->invitation->school;
        $inviter = $this->invitation->inviter?->name ?? 'Guru Besar';

        return (new MailMessage)
            ->subject("Jemputan menyertai {$school->name} di eKafa Online")
            ->greeting('Assalamualaikum ' . $this->invitation->name . ',')
            ->line("{$inviter} menjemput anda menyertai {$school->name} sebagai {$this->invitation->role} di eKafa Online.")
            ->action('Terima Jemputan', route('invitations.show', $this->token))
            ->line('Pautan ini sah selama ' . Invitation::VALID_DAYS . ' hari.')
            ->line('Jika anda tidak mengenali pengirim, abaikan e-mel ini.')
            ->salutation('Salam hormat, Pasukan eKafa Online');
    }
}

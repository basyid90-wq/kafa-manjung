<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAnnouncementNotification extends Notification
{
    use Queueable;

    protected $announcement;

    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'announcement',
            'title' => 'Hebahan Baharu: ' . $this->announcement->title,
            'message' => 'Terdapat hebahan baharu daripada ' . $this->announcement->user->name,
            'url' => route('announcements.show', $this->announcement->id),
            'announcement_id' => $this->announcement->id,
        ];
    }
}

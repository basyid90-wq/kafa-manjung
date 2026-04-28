<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
{
    use Queueable;

    protected $order;
    protected $status;

    public function __construct($order, $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $statusText = match($this->status) {
            'submitted_by_school'    => 'Telah Dihantar untuk Semakan',
            'approved_by_admin'      => 'Telah Diluluskan oleh Admin',
            'processing_by_supplier' => 'Sedang Diproses oleh Pembekal',
            'delivered_to_school'    => 'Telah Dihantar ke Sekolah',
            'completed'              => 'Telah Selesai',
            default                  => $this->status,
        };

        return [
            'type' => 'order_status',
            'title' => 'Status Tempahan Buku #' . $this->order->id,
            'message' => 'Tempahan buku anda ' . $statusText,
            'url' => route('book_orders.show', $this->order),
            'order_id' => $this->order->id,
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class StatusPesananNotification extends Notification
{
    use Queueable;

    public $pesanan;

    public function __construct($pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Pesanan #{$this->pesanan->id} telah diperbarui menjadi {$this->pesanan->status}.",
            'url' => route('pesanan.detail', $this->pesanan->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => "Pesanan #{$this->pesanan->id} telah diperbarui menjadi {$this->pesanan->status}.",
            'url' => route('pesanan.detail', $this->pesanan->id),
        ]);
    }
}

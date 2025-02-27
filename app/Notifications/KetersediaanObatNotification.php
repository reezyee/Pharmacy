<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class KetersediaanObatNotification extends Notification
{
    use Queueable;

    public $obat;

    public function __construct($obat)
    {
        $this->obat = $obat;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Obat {$this->obat->nama} kini tersedia!",
            'url' => route('obat.detail', ['id' => $this->obat->id])
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => "Obat {$this->obat->nama} kini tersedia!",
            'url' => route('obat.detail', ['id' => $this->obat->id])
        ]);
    }
}

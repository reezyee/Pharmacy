<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ChatNotification extends Notification
{
    use Queueable;

    public $message;
    public $sender;

    public function __construct($message, $sender)
    {
        $this->message = $message;
        $this->sender = $sender;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Pesan baru dari {$this->sender->name}: {$this->message}",
            'url' => route('chat.show', $this->sender->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => "Pesan baru dari {$this->sender->name}: {$this->message}",
            'url' => route('chat.show', $this->sender->id),
        ]);
    }
}

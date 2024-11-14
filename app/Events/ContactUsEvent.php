<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactUsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userName;

    public $userEmail;

    public $subject;

    public $messageContent;

    public function __construct($userName, $userEmail, $subject, $messageContent)
    {
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->subject = $subject;
        $this->messageContent = $messageContent;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}

<?php

namespace App\Events;

use App\Models\{ ToolOrder , User};
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalOrderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order , $user;

    public function __construct(ToolOrder $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}

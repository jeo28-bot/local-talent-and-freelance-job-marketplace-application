<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class IncomingCall implements ShouldBroadcastNow
{
    public $callerId;
    public $receiverId;
    public $roomName;

    public function __construct($callerId, $receiverId, $roomName)
    {
        $this->callerId = $callerId;
        $this->receiverId = $receiverId;
        $this->roomName = $roomName;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->receiverId);
    }

    public function broadcastAs()
    {
        return 'incoming-call';
    }
}

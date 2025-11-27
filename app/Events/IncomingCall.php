<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IncomingCall implements ShouldBroadcast
{
    public $data;
    private $receiverId;

    public function __construct($receiverId, $data)
    {
        $this->receiverId = $receiverId;
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return new Channel('chat-channel-'.$this->receiverId);
    }
}

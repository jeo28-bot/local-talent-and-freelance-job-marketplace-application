<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoCallSignal implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $signal;
    public $from;
    public $to;

    public function __construct($signal, $from, $to)
    {
        $this->signal = $signal;
        $this->from = $from;
        $this->to = $to;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('video-call.' . $this->to);
    }

}

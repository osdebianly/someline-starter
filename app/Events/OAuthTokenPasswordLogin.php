<?php

namespace Someline\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OAuthTokenPasswordLogin
{
    use InteractsWithSockets, SerializesModels;
    
    public $tokenInfo;

    /**
     * Create a new event instance.
     * @param array $tokenInfo
     */
    public function __construct($tokenInfo)
    {
        $this->tokenInfo = $tokenInfo;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

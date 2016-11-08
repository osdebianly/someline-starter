<?php

namespace Someline\Events;

use Someline\Events\Event;
use Someline\Models\Foundation\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderPaid extends Event
{
    use SerializesModels;

    public $data;

    /**
     * Create a new event instance.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;

    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}

<?php

namespace App\Events;

use App\Events\Event;
use App\Models\ClassSessions\ClassSessions;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewClassSession extends Event
{
    use SerializesModels;

    // class session
    public $s = null;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( ClassSessions $s )
    {
        $this->s = $s;
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

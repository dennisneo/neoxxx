<?php

namespace App\Events;

use App\Events\Event;
use App\Models\ClassSessions\ClassSessions;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CancelClassSessionEvent extends Event
{
    use SerializesModels;

    public $classSession;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( ClassSessions $class )
    {
        $this->classSession = $class;
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

<?php

namespace App\Listeners;

use App\Events\NewStudentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NewStudentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewStudentEvent  $event
     * @return void
     */
    public function handle(NewStudentEvent $event)
    {

    }
}

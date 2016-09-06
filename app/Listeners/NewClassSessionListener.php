<?php

namespace App\Listeners;

use App\Events\NewClassSession;
use App\Models\Financials\Credits;
use App\Models\Messaging\Notifications;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewClassSessionListener
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
     * @param  NewClassSession  $event
     * @return void
     */
    public function handle( NewClassSession $event )
    {
        $cs = $event->s;

        // charge credits to user
        $credits    = Credits::getCreditsByStudentId( $cs->student_id , true );
        $credits->credits  = $credits->credits - $cs->credits;
        $credits->save();

        // send notifications to admin, teacher and student
        $n = new Notifications();
        $n->send( 'new class assignment', [
            'notification' => trans( 'general.new_class_assignment' ),
            'sent_to' => $cs->teacher_id
        ]);

        // send email to admin, teacher and student
    }
}

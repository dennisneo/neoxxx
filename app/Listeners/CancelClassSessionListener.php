<?php

namespace App\Listeners;

use App\Events\CancelClassSessionEvent;
use App\Models\Financials\Credits;
use App\Models\Financials\Notifications;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelClassSessionListener
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
     * @param  'CancelClassSession'  $event
     * @return void
     */
    public function handle( CancelClassSessionEvent $event)
    {
        //
        $cs = $event->classSession;

        // refund the credits to user
        $credits = Credits::getCreditsByStudentId( $cs->student_id , true );
        $credits->credits  =  $credits->credits + $cs->credits;
        $credits->save();

        // send notifications to admin, teacher and student
        if( $cs->teacher_id ){
            $n = new Notifications();
            $n->send( 'class assignment cancelled', [
                'notification' => trans( 'general.class_assignment_cancelled' ),
                'send_to' => $cs->teacher_id
            ]);
        }

    }
}

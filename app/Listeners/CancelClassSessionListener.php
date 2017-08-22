<?php

namespace App\Listeners;

use App\Events\CancelClassSessionEvent;
use App\Models\Financials\Credits;

use App\Models\Messaging\Notifications;
use Carbon\Carbon;
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

        $sched = date( 'M d, Y H:s a', strtotime(  $cs->schedule_start_at ) );

        $email_message = ' Hi, <br /><br /> Your class scheduled at '.$sched.' has been canceled. For further questions, please contact admin ';
        $email_message .= ' <br /><br />Thank you <br /> '.env('COMPANY_NAME');

        $n_message = 'Your class scheduled for '.$sched.' has been canceled. For further questions, please contact admin';

        // send notifications to admin, teacher and student

        if( $cs->teacher_id ){

            $n = new Notifications();
            $n->send( 'class assignment cancelled', [
                'notification' => $n_message,
                'sent_to' => $cs->teacher_id
            ]);

        }

        if( $cs->student_id ){

            $n = new Notifications();
            $n->send( 'class assignment cancelled', [
                'notification' => $n_message,
                'sent_to' => $cs->student_id
            ]);

        }

    }
}

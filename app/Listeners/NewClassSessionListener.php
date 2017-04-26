<?php

namespace App\Listeners;

use App\Events\NewClassSession;
use App\Models\Financials\Credits;
use App\Models\Messaging\Notifications;
use App\Models\Users\StudentEntity;
use App\Models\Users\TeacherEntity;
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
        $this->sendBackendNotifications( $cs );

        // send email teacher
        $this->sendNotificationEmailToTeacher(  $cs );

        // send email to student

        // send email to admins

    }

    private function sendBackendNotifications( $class_session )
    {
        $n = new Notifications();
        $n->send( 'new class assignment', [
            'notification' => trans( 'general.new_class_assignment' ),
            'sent_to' => $class_session->teacher_id
        ]);

        return $n;
    }

    private function sendNotificationEmailToTeacher( $class_session )
    {

        $teacher = TeacherEntity::find( $class_session->teacher_id );
        $student = StudentEntity::find( $class_session->student_id );

        view()->addLocation( __DIR__.'/../Http/Views/emails' );

        // check first if email is valid
        \Mail::send( 'new_class_session', [ 'teacher' => $teacher, 'student' => $student ,
           'class_session' => $class_session ],
            function( $m ) use ( $teacher   ) {
                $m->from( env( 'APP_EMAIL_SENDER' ),  env( 'COMPANY_NAME' ) );
                $m->to( $teacher->email , $teacher->displayName() )
                    ->subject( 'New Class Session' );
            }
        );

    }
}

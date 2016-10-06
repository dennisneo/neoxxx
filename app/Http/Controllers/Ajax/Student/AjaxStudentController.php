<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */
namespace App\Http\Controllers\Ajax\Student;

use App\Events\CancelClassSessionEvent;
use App\Events\NewClassSession;
use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\ClassSessions\ClassSessions;
use App\Models\Financials\Credits;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Users\Applicant;
use App\Models\Users\StudentEntity;
use App\Models\Users\TeacherEntity;
use App\Models\Users\Teachers;
use Helpers\Text;
use Illuminate\Http\Request;
use Event;

class AjaxStudentController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    /**
     * first step before saving a class session
     *
     * @param Request $r
     * @return array
     */
    public function setupClassSession( Request $r )
    {
        $s = new ClassSessions();

        if( ! $session = $s->store( $r ) ){
            return [
                'success' => false,
                'message' => $s->getErrors(),
            ];
        }

        return [
            'success' => true,
            's' => $session,
            'cid' => Text::convertInt( $session->class_id )
        ];
    }

    /**
     * saving a class session will make the session a go
     *
     * @param Request $r
     * @return array
     */
    public function saveClassSession( Request $r )
    {
        // do some checks for validity of the class session
        if( ! $s = ClassSessions::find( $r->cid ) ){
            return [
                'success' => false,
                'message' => trans( 'general.invalid_class_session' )
            ];
        }

        // check if availble credits is more than session credit
        $available_credit = Credits::getCreditsByStudentId( $s->student_id );

        \DB::beginTransaction();
        if( $available_credit < $s->credits ){
            return [
                'success' => false,
                'message' => trans( 'general.insufficient_funds' )
            ];
        }

        $s->status = 'active';
        $s->save();

        // fire new class event
        // capture errors so easier to debug
        try{

            Event::fire( new NewClassSession( $s ) );

        }catch( \Exception $e ){

            \DB::rollback();
            return [
                'success' => false,
                'message' => 'Something went wrong',
                'error_message' => $e->getMessage()
            ];
        }

        \DB::commit();

        return [
            'success' => true,
            's' => $s,
            'cid' => Text::convertInt( $s->class_id )
        ];
    }

    public function cancelClassSession( Request $r )
    {
        // do some checks for validity of the class session
        if( ! $s = ClassSessions::find( $r->cid ) ){
            return [
                'success' => false,
                'message' => trans( 'general.invalid_class_session' )
            ];
        }

        //@TODO only admins and student can cancel a session

        $s->status = 'cancelled';
        $s->save();

        // fire new class event
        Event::fire( new CancelClassSessionEvent( $s ) );


    }

    public function availableTeachers( Request $r )
    {
        if( ! $class_session = ClassSessions::find( $r->cid ) ){
            return [
                'success' =>false,
                'message' => trans( 'invalid_class_session' )
            ];
        }
        $teachers = Teachers::getAvailableTeachers( $class_session->schedule_start_at );
        $t_arr = [];
        foreach( $teachers as $t ){
            $t_arr[] = $t->vuefyTeacher();
        }

        return [
            'success' => true,
            'teachers' => $t_arr
        ];
        
    }

    public function teacherSelected( Request $r )
    {

        if( ! $class_session = ClassSessions::find( $r->cid ) ){
            return [
                'success' =>false,
                'message' => trans( 'invalid_class_session' )
            ];
        }

        if( ! $teacher = TeacherEntity::find( $r->tid ) ){
            return [
                'success' =>false,
                'message' => trans( 'invalid_teacher_id' )
            ];
        }

        $class_session->teacher_id = $r->tid;
        $class_session->save();

        $teacher->vuefyTeacher();

        return [
            'success' => true,
            'teacher' => $teacher
        ];
    }

    public function getStudentCredits( Request $r )
    {
        $sid = $r->sid;
        if( ! $student = StudentEntity::find( $sid ) ){
            return [
                'success' =>false,
                'message' => 'Student not found'
            ];
        }

        $credits = Credits::getCreditsByStudentId( $sid );
        return [
            'success' =>true,
            'sid' => $sid,
            'credits' => $credits
        ];

    }

    public function getStudentSessions( Request $r )
    {
        $cs = new ClassSessions;
        $class_sessions = $cs->byStudentId( $r->sid , $r );
        
        return [
            'success' =>true,
            'sessions' => $class_sessions
        ];

    }
}
<?php

namespace App\Http\Controllers\Ajax\Student;

use App\Events\CancelClassSessionEvent;
use App\Events\NewClassSession;
use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\ClassSessions\ClassFeedback;
use App\Models\ClassSessions\ClassSessions;
use App\Models\Financials\Credits;
use App\Models\LearningGoals\LearningGoalMap;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Messaging\Notes;
use App\Models\Placement\ExamSessions;
use App\Models\Settings\Settings;
use App\Models\Users\Applicant;
use App\Models\Users\StudentEntity;
use App\Models\Users\Students;
use App\Models\Users\Students\StudentCredits;
use App\Models\Users\Students\StudentSettings;
use App\Models\Users\TeacherEntity;
use App\Models\Users\Teachers;
use App\Models\Users\UserEntity;
use Helpers\DateTimeHelper;
use Helpers\Text;
use Illuminate\Http\Request;
use Event;
use Illuminate\Support\Facades\Session;

class AjaxStudentController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function getMySchedule( Request $r )
    {
        $cs = new ClassSessions;
        $r->request->add(['incoming_only' => true , 'class_status' => [ 'completed' , 'active'] ]);
        $class_sessions = $cs->byStudentId( $r->user()->id , $r );

        return [
            'success' =>true,
            'sessions' => $class_sessions
        ];
    }

    public function sendConfirmationEmail( Request $r )
    {
        $student = UserEntity::me();
        if( $student->confirmed ){
            return [
                'success' =>false,
                'message' => 'You had previously confirmed your email already'
            ];
        }

        $student->resendConfirmationEmail();

        return [
            'success' =>true
        ];
    }

    public function isEmailConfirmed( Request $r )
    {

        if( ! $r->user()->id ){
            return [
                'success' =>true,
                'confirmed' => false
            ];
        }

        if( ! $r->user()->confirmed ){
            return [
                'success' =>true,
                'confirmed' => false
            ];
        }

        return [
            'success' =>true,
            'confirmed' => true
        ];
    }

    /**
     * @param ClassSessions $class
     * @param Request $r
     * @return array
     */
    public function cancelClass( ClassSessions $class, Request $r )
    {
        if( $r->user()->id != $class->student_id ){
            return [
                'success' =>false,
                'message' => 'You are not allowed to cancel this class session'
            ];
        }

        if( ! $class->cancel() ){
             return [
                 'success' =>false,
                 'message' => $class->displayErrors()
             ];
        }

        return [
            'success' =>true,
            'class' => $class->vuefy(['with_teacher'=> true ])
        ];
    }

    public function getIncomingSchedules( Request $r )
    {
        $r->request->add(['incoming_only' => true ]);
        $sessions = (new ClassSessions)->byStudentId( $r->sid , $r );
        return [
            'success' =>true,
            's' => $sessions
        ];
    }

    public function bookClass( Request $r )
    {
        return [
            'success' =>true
        ];
    }

    public function getPlacementExam( Request $r )
    {
        $exam_sessions = ( new ExamSessions() )->getByStudentIdVuefy( $r );
        $can_retake = StudentSettings::getByKey( 'can_retake_exam' , false);

        return [
            'success' =>true,
            'exam_sessions' => $exam_sessions,
            'can_retake' => $can_retake
        ];
    }

    public function saveProfile( Request $r )
    {
        $student = new StudentEntity();

        if( ! $student->store( $r ) ){
            return [
                'success' =>false,
                'message' => $student->displayErrors()
            ];
        }

        $student = ( new StudentEntity )->getByUserId( $student->id );

        return [
            'success' =>true,
            'student' => $student
        ];
    }

    public function getStudent( Request $r )
    {

        if( ! $student = StudentEntity::find( $r->sid ) ){
            return [
                'success' =>false,
                'message' => 'Student not found'
            ];
        }

        $classes    = ( new ClassSessions )->getAll( $r );
        $notes      = Notes::byUserId( $r->sid , $r )->vuefyNotesCollection();
        $pe         = ( new ExamSessions )->getByStudentId( $r->sid ,  $r );

        return [
            'success' =>true,
            'student' => $student->vuefyStudent(),
            'classes' => $classes,
            'notes' => $notes,
            'exams' => $pe
        ];

    }

    public function searchTeachers( Request $r )
    {
        $t  =  ( new Teachers() )->getTeachers( $r ) ;
        $teachers = ( new Teachers() )->vuefyAll( $t );

        return [
            'success' =>    true,
            'teachers' => $teachers
        ];
    }

    public function getTeacherSchedule( Request $r )
    {
        $me = UserEntity::me();

        // get only the seven day sched
        if( $r->date_from  ) {
            $from = new \DateTime( $r->date_from );
        }else{
            $from = DateTimeHelper::now( $me->timezone );
        }

        $date_from = $from->format( 'Y-m-d' );
        $date_to = $from->add(new \DateInterval('P7D'))->format('Y-m-d');

        $r->request->add(['date_from'=>$date_from , 'date_to'=>$date_to ]);

        $sessions = ( new ClassSessions )->byTeacherId( $r );

        return [
            'success' => true,
            'sessions' => $sessions,
            'date_from' => $date_from,
            'date_to' => $date_to
        ];
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

        $r->request->add(['class_status'=>'for confirmation']);

        if( ! $session = $s->store( $r ) ){
            return [
                'success' => false,
                'message' => $s->getErrors(),
                'error_code' => $s->error_code
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
            $session = $this->setupClassSession( $r );

            if( $session['success'] ){
                $s = $session['s'];
            }else{
                return [
                    'success' => false,
                    //'message' => trans( 'general.invalid_class_session' )
                    'message' => $session['message']
                ];
            }


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

        $s->class_status = 'active';
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

        return [
            'success' =>true,
            'session' => $s
        ];
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

        $credits = StudentCredits::getCreditsByStudentId( $sid );

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

    public function getFeedback( Request $r )
    {
        $class_id = Text::recoverInt( $r->class_id );
        $feedback = ClassFeedback::where( 'class_id' , $class_id )->first();

        return [
            'success' =>true ,
            'feedback' => $feedback
        ];
    }

    public function saveFeedback( Request $r )
    {
        $class_id = Text::recoverInt( $r->class_id );

        if( ! $feedback = ClassFeedback::where( 'class_id' , $class_id )->first() ){
            $feedback = new ClassFeedback();
            $feedback->class_id = $class_id;
        }

        if( ! $feedback->store( $r ) ) {
            return [
                'success' => false,
                'messsage' => ' Failed to save feedback '
            ];
        }

        return [
            'success' =>true ,
            'feedback' => $feedback
        ];
    }

    public function getLearningGoals( Request $r ){
        $lg = LearningGoalMap::getLearningGoalsByStudentId( $r->sid );
        return [
            'success' =>true,
            'lg' => $lg
        ];
    }

    public function saveLearningGoals( Request $r )
    {
        \DB::beginTransaction();

        try{
            LearningGoalMap::purgeAndSave( $r );
        }catch( \Exception $e ){
            \DB::rollback();
            return [
                'success'   => false,
                'message'  => $e->getMessage()
            ];
        }

        \DB::commit();

        return [
            'success' =>true
        ];
    }

    public function autocomplete( Request $r )
    {
        $r->merge(['q' => $r->term ]);
        $students  =  ( new Students() )->getStudents( $r );
        $t_arr = [] ;

        foreach( $students as $t ) {
            $t_arr[] = [ 'id'=>$t->id , 'value'=>$t->full_name ];
        }

        return [
            'success' =>true,
            'students' => $t_arr
        ];
    }

}
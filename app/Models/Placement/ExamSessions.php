<?php

namespace App\Models\Placement;

use App\Models\BaseModel;
use App\Models\LearningGoals\LearningGoalMap;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Settings\Settings;
use Illuminate\Http\Request;
use Validator;

class ExamSessions extends BaseModel
{
    protected $table        = 'exam_sessions';
    protected $primaryKey   = 'eid';
    public $timestamps      = false;

    public $fillable = [];

    public function isDone( $student_id )
    {
        $count = static::where( 'student_id' , $student_id  )
            ->where( 'status' , 'Done')
            ->count();

        return $count ? true : false;
    }

    public function getByStudentIdVuefy( Request $r )
    {
        $this->collection = $this->getByStudentIdRaw( $r );
        return $this->vuefyThisCollection();
    }

    public function getByStudentIdRaw( Request $r )
    {
        $student_id = $r->sid;
        $exams = static::where( 'student_id' , $student_id  )
            ->from( 'exam_sessions as es')
            ->get();

        return $exams;
    }

    public function getByStudentId( $student_id , Request $r )
    {

        $this->limit =  20;
        $page       = $r->page ? $r->page : 1;
        $offset     = ( $page - 1 ) * $this->limit;
        $order_by   = $r->order_by ? $r->order_by : 'started_at';
        $order_direction = $r->order_direction ? $r->order_direction : 'ASC';

        $exams = static::where( 'student_id' , $student_id  )
        ->from( 'exam_sessions as es')
        ->join( 'exam_results as er', 'er.session_id' , '=' ,  'es.eid' )
        ->limit( $this->limit )
        ->orderBy( $order_by , $order_direction )
        ->get( [ 'es.*', 'er.*', 'es.session_id as session_id' ] );

        return $exams;
    }

    public function createNew( Request $r )
    {
        if( ! $r->student_id ){
            throw new \Exception( 'Invalid stduent id' );
        }

        $this->session_id = $this->generateSessionId();
        $this->student_id = $r->student_id;
        $this->status     = 'on going';
        $this->item_count = Settings::getByKey( 'exam_items', 40 );
        $this->started_at = date( 'Y-m-d H:i:s');
        $this->last_question_shown_at = date( 'Y-m-d H:i:s');
        $this->current_item  = 1;
        $this->save();

        return $this;
    }

    /**
     * returns a question object
     */
    public function getNewQuestion()
    {
        if( ! $this->session_id ){
            throw new \Exception( trans('errors.invalid_session') );
        }

        if( ! $this->student_id ){
            throw new \Exception( trans('errors.invalid_student_id') );
        }

        // get student leaning goals
        $lgs = LearningGoalMap::getLearningGoalsByStudentId( $this->student_id );

        $lg_arr = [];
        foreach( $lgs as $lg ){
            $lg_arr[] = $lg->learning_goal_id;
        }

        if( empty( $lg_arr ) ){
            throw new \Exception( trans('errors.no_learning_goal_found') );
        }

        // get all questions answered already
        $done_questions = ExamAnswers::where( 'session_id' , $this->session_id )
            ->pluck('question_id')->toArray();

        $question = Questions::whereIn( 'cat_id' , $lg_arr )
         ->inRandomOrder();

        if( count( $done_questions ) ){
            $question->whereNotIn( 'q_id', $done_questions );
        }

        if( ! $question = $question->first() ){
           throw new \Exception( trans( 'errors.no_more_questions_found' ) );
        }

        $question->choices = ( new QuestionChoices )->getByQuestionId( $question->q_id )->vuefyCollection();

        return $question;
    }

    /***
     *
     */
    public function setAsDone()
    {
        // check if session id was already created
        if( ! $this->eid ){
            $this->errors[] = ' Invalid session id';
            return false;
        }

        $this->status = 'done';
        $this->completed_at = date( 'Y-m-d H:i:s' );
        $this->save();

        $this->computeResult();

        return $this;
    }

    /**
     * compute results when done
     */
    private function computeResult()
    {
        // get all answers for this question
        $answers = ExamAnswers::where( 'session_id' , $this->eid )
            ->from( 'exam_answers as a' )
            ->join( 'questions as q' , 'q.q_id' , '=', 'a.question_id' )
            ->get();

        //$lg_array = LearningGoals::all()->pluck('goal', 'goal_id')->toArray();

        $a_arr = [];
        foreach( $answers as $a ){
            if( $a->is_correct ){
                $a_arr[$a->cat_id]['correct'] = isset( $a_arr[$a->cat_id]['correct'] ) ? $a_arr[$a->cat_id]['correct'] + 1 : 1;
            }else{
                $a_arr[$a->cat_id]['wrong'] = isset( $a_arr[$a->cat_id]['wrong'] ) ? $a_arr[ $a->cat_id ]['wrong'] + 1 : 1;
            }
        }

        foreach( $a_arr as $k => $a ){

            $r = new ExamResults();
            $r->session_id = $this->eid;
            $r->cat_id = $k;
            $r->correct = isset( $a['correct'] ) ? $a['correct'] : 0 ;
            $r->wrong = isset( $a['wrong'] ) ? $a['wrong'] : 0 ;
            $r->total_items = $r->correct + $r->wrong;
            $r->rating = $r->correct / $r->total_items;
            $r->save();

        }

        return;

    }

    public static function getOngoingByStudentid( $student_id )
    {
        return static::where( 'status', 'on going' )
            ->where( 'student_id' , $student_id )
            ->first();
    }

    private function generateSessionId()
    {
        $session_id =  str_random( 24 );
        // check if session id is avail
        $taken = static::where( 'session_id' , $session_id )
            ->first();

        if( $taken ){
            $session_id = $this->generateSessionId();
        }

        return $session_id;
    }

}

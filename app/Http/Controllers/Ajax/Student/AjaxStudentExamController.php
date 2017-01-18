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
use App\Models\ClassSessions\ClassFeedback;
use App\Models\ClassSessions\ClassSessions;
use App\Models\Financials\Credits;
use App\Models\LearningGoals\LearningGoalMap;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Placement\ExamAnswers;
use App\Models\Placement\ExamResults;
use App\Models\Placement\ExamSessions;
use App\Models\Placement\QuestionChoices;
use App\Models\Placement\Questions;
use App\Models\Users\Applicant;
use App\Models\Users\StudentEntity;
use App\Models\Users\TeacherEntity;
use App\Models\Users\Teachers;
use App\Models\Users\UserEntity;
use Helpers\DateTimeHelper;
use Helpers\Text;
use Illuminate\Http\Request;
use Event;
use Illuminate\Support\Facades\Session;

class AjaxStudentExamController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function getQuestions( Request $r )
    {
        // check is Student already took the exam
        if( ( new ExamSessions)->isDone( $r->student_id ) ){
            return [
                'success' =>false,
                'message' => 'You have already taken the placement exam. If you need to take another, please send a request to admin '
            ];
        }
        // check for unfinished sessions
        if( ! $session = ExamSessions::getOngoingByStudentid( $r->student_id ) ){

            // create session if no unfinished session is found
            $session = new ExamSessions();

            try{
                $session->createNew( $r );
            }catch ( \Exception $e ){
                return [
                    'success' =>false,
                    'message' => $e->getMessage()
                ];
            }
        }

        // get students learning goals then get a new question base on those goals

        if( ! $question = $session->getNewQuestion() ){

            return [
                'success' =>false,
                'messsage' => 'No more questions found'
            ];

        }

        return [
            'success' => true,
            'question' => $question,
            'session' => $session,
            'q_id' => $question->q_id
        ];
    }

    public function submitAnswer( Request $r )
    {
        if( ! $r->choice_id ){
            return [
                'success' =>false,
                'message' => trans( 'errors.you_need_select_an_answer' )
            ];
        }

        if( ! $session = ExamSessions::find( $r->session_id ) ){
            return [
                'success' => false,
                'message' => trans( 'errors.exam_session_not_found' )
            ];
        }

        // check if user already answered this question
        $answer = ( new ExamAnswers )->store( $r );

        // check if exam session is last item
        if( $session->current_item  == $session->item_count ){
            // do something here
            if( ! $session->setAsDone() ){
                return [
                    'success'  => false,
                    'messsage' => $session->displayErrors()
                ];
            }

            $results =  ( new ExamResults() )->getByExamSessionId( $session->eid );

            return [
                'success' =>true,
                'is_done' => true,
                'results' => $results,
                'session' => $session
            ];
        }

        // increment current item for the session
        $session->current_item = $session->current_item + 1;
        $session->save();

        // get new question
        $question = $session->getNewQuestion();

        return [
            'success' =>true,
            'is_done' => false,
            'question' => $question,
            'session' => $session
        ];
    }

}
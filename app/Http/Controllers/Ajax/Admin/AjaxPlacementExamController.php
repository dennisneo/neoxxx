<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Placement\QuestionChoices;
use App\Models\Placement\Questions;
use Illuminate\Http\Request;

class AjaxPlacementExamController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function saveQuestion( Request $r )
    {

        \DB::beginTransaction();
        $question =  new Questions();

        if( ! $question->store( $r ) ){
            return [
                'success' => false,
                'message' => $question->getErrors()
            ];
        }

        if( isset( $r->c ) && is_array( $r->c )){
            foreach( $r->c as $k=>$c ){
                $choice = new QuestionChoices;
                $choice->choice = $c;
                $choice->is_answer = 0;

                if( $r->answer == $k ){
                    $choice->is_answer = 1;
                }

                $choice->q_id = $question->q_id;
                if( ! $choice->store( $r , $c  ) ){
                    \DB::rollback();
                }

            }
        }

        \DB::commit( );

        return [
            'success'   => true,
            'question'  => $question
        ];

    }

    public function getQuestions( Request $r )
    {
        $qs = new Questions;
        $questions = $qs->getQuestions( $r );

        $qids_arr = [];
        foreach( $questions as $q ){
            $qids_arr[] = $q->q_id;
        }

        $choices = $qs->getChoices( $qids_arr);
        /**
        $questions_arr = [];
        foreach( $questions as $q ){
            if( isset( $choices[]))
            $questions_arr[] = $q;
        }
        ***/
        return [
            'success' => true,
            'questions' => $questions,
            'choices' => $choices
        ];
    }

    public function deleteLearningGoal( Request $r ){

        $goal = LearningGoals::find( $r->gid );
        $goal->delete();

        return [
            'success' => true ,
            'gid' => $r->gid
        ];
    }
}
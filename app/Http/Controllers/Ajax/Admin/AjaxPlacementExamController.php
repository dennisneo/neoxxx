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
use App\Models\Users\Applicant;
use Illuminate\Http\Request;

class AjaxPlacementExamController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function saveQuestion( Request $r )
    {
        $question =  new Questions();

        if( ! $question->store( $r ) ){
            return [
                'success' => false,
                'message' => $question->getErrors()
            ];
        }

        if( isset( $r->c ) && is_array( $r->c )){
            foreach( $r->c as $c ){
                $choice = new QuestionChoices;
                $choice->store( $r , $c );
            }
        }


        return [
            'success'   => true,
            'question'  => $question
        ];
    }

    public function getLearningGoals( Request $r )
    {
        $goals = LearningGoals::all();

        return [
            'success' => true,
            'goals' => $goals
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
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
use App\Models\Users\Applicant;
use Illuminate\Http\Request;

class AjaxLearningGoalController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function saveLearningGoal( Request $r )
    {
        $goal = new LearningGoals;

        if( ! $goal->store($r ) ){
            return [
                'success' => false,
                'message' => $goal->getErrors()
            ];
        }

        return [
            'success' => true,
            'goal' => $goal
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
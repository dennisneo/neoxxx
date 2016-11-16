<?php

namespace App\Http\Controllers\Ajax\Student;

use App\Events\CancelClassSessionEvent;
use App\Events\NewClassSession;
use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\ClassSessions\ClassFeedback;
use App\Models\ClassSessions\ClassSessions;
use App\Models\Financials\CreditCost;
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
use App\Models\Users\Students\StudentCredits;
use App\Models\Users\TeacherEntity;
use App\Models\Users\Teachers;
use App\Models\Users\UserEntity;
use Helpers\DateTimeHelper;
use Helpers\Text;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Event;
use Illuminate\Support\Facades\Session;

class AjaxStudentCreditsController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function buy( Request $r )
    {
        if( ! $r->sid ){
            return [
                'success' => false,
                'message' => ''
            ];
        }

        if( ! $credit_cost = CreditCost::find( $r->cost_id ) ){
            return [
                'success' =>false,
                'message' => 'Credit cost package not found !'
            ];
        }

        //wepay transactions here
        $student_id  = Text::recoverInt( $r->sid );
        $r->request->add( [
            'cost_id'   =>$credit_cost->cost_id,
            'credits'   =>$credit_cost->credits,
            'cost'      =>$credit_cost->cost,
            'amount'    =>$credit_cost->cost,
            'user_id' => UserEntity::me()->id
        ]);
        $credits     = StudentCredits::getCreditsByStudentId(  $student_id , true);
        $credits->add( $r );

        return [
            'success' =>true,
            'credit' => $credits
        ];

    }
}
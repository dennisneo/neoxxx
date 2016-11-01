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

        $student_id =  Text::recoverInt( $r->sid );

        $credits    = StudentCredits::getCreditsByStudentId(  $student_id , true);
        $credits->add( $r->credits );

        return [
            'success' =>true,
            'credit' => $credits
        ];

    }
}
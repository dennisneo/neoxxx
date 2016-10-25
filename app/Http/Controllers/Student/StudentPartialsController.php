<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassSessions\ClassSessions;
use App\Models\Users\TeacherEntity;
use App\Models\Users\Teachers;
use App\Models\Users\UserEntity;
use Helpers\DateTimeHelper;
use Helpers\Html;
use Illuminate\Http\Request;

class StudentPartialsController extends StudentBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public static function findTeachersPartial( Request $r )
    {
        $me = UserEntity::me();

        $next_seven_days = DateTimeHelper::nextSevenDays( $me->timezone );
        $time_array = DateTimeHelper::timeTrList();

        Html::instance()->addScript( '/public/app/student/partials/find_teachers.js'  );
        return view( 'student.partials.find_teachers' ,
            [
                'next_seven_days' => $next_seven_days,
                'time_array' => $time_array
            ]
        );
    }

    public static function placementExamPartial( Request $r )
    {
        Html::instance()->addScript( '/public/app/student/partials/placement_exam.js'  );
        return view( 'student.partials.placement_exam' ,
            []
        );
    }

    public static function bookClassPartial( Request $r )
    {
        Html::instance()->addScript( '/public/app/student/partials/book_class.js'  );
        Html::loadDateCombo();
        Html::loadDatepicker();
        return view( 'student.partials.book_class' , [] );
    }
}
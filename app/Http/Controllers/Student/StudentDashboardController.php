<?php

namespace App\Http\Controllers\Student;

use App\Models\Users\StudentEntity;
use App\Models\Users\TeacherEntity;
use App\Models\Users\Teachers;
use App\Models\Users\UserEntity;
use Helpers\Html;
use Illuminate\Http\Request;

class StudentDashboardController extends StudentBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index( Request $r )
    {
        $this->indexAssets();
        $this->layout->content = view( 'student.student_dashboard' , [ 'r' => $r ] );
        return $this->layout;
    }

    public function profile( Request $r )
    {
        $student = ( new StudentEntity() )->getByUserId( UserEntity::me()->id );

        $this->layout->content  =  view('student.student_profile' , [ 's' => $student ] );
        Html::instance()->addScript( 'public/app/student/student_profile.js' );
        Html::loadDateCombo();
        Html::loadFileupload();
        return $this->layout;
    }

    public function gettingStarted( Request $r )
    {
        $this->layout->content = view( 'student.getting_started' , [ 'r' => $r ] );
        return $this->layout;
    }

    public function buyCredits()
    {
        $this->layout->content = view( 'student.buy_credits' );
        Html::instance()->addScript( '/public/app/student/buy_credits.js' );

        return $this->layout;
    }

    public function teachers( Request $r )
    {
        $this->layout->content = view( 'student.available_teachers' , ['r' => $r ] );
        Html::instance()->addScript( '/public/app/student/student_teachers.js' );
        return $this->layout;
    }

    public function teacher( $id , Request $r )
    {
        $id = Text::recoverInt( $id );

        if( $teacher = TeacherEntity::find( $id ) ){
            $teacher->vuefyTeacher();
            $this->layout->content = view( 'student.teacher' , ['t'=> $teacher ]);
            Html::instance()->addScript( '/public/app/student/student_teacher.js' );
        }else{
            $this->layout->content =  'Teacher not found';
        }

        return $this->layout;
    }

    private function indexAssets()
    {

        Html::loadDatepicker();
        Html::loadToastr();
        Html::instance()->addScript( '/public/app/student/student_dashboard.js' );
    }

}
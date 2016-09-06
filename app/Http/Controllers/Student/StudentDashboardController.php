<?php

namespace App\Http\Controllers\Student;

use App\Models\Users\Teachers;
use Helpers\Html;
use Illuminate\Http\Request;

class StudentDashboardController extends StudentBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->indexAssets();
        $this->layout->content = view( 'student.student_dashboard' );
        return $this->layout;
    }

    public function buyCredits()
    {
        $this->layout->content = view( 'student.buy_credits' );
        return $this->layout;
    }

    public function teachers( Request $r )
    {
        $this->layout->content = view( 'student.available_teachers');
        Html::instance()->addScript( '/public/app/student/student_teachers.js' );
        return $this->layout;
    }

    public function teacher( Request $r )
    {
        $this->layout->content = view( 'student.teacher');
        Html::instance()->addScript( '/public/app/student/student_teacher.js' );
        return $this->layout;
    }

    private function indexAssets()
    {
        Html::loadDateCombo();
        Html::loadDatepicker();
        Html::loadToastr();
        Html::instance()->addScript( '/public/app/student/student_dashboard.js' );
    }

}
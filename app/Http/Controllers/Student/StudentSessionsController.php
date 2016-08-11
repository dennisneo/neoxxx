<?php

namespace App\Http\Controllers\Student;

use Helpers\Html;

class StudentSessionsController extends StudentBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function newSession()
    {
        $this->indexAssets();
        $this->layout->content = view( 'student.student_session' );
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
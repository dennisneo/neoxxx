<?php

namespace App\Http\Controllers\Teacher;


use Helpers\Html;

class TeacherScheduleController extends TeacherBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->layout->content  =  view('teacher.teacher_schedule');
        Html::instance()->addScript( 'public/app/teacher/teacher_schedule.js' );
        Html::loadFileupload();
        Html::loadDatepicker();
        return $this->layout;
    }

}
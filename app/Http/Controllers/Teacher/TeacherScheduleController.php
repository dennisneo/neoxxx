<?php

namespace App\Http\Controllers\Teacher;

use Helpers\Html;
use Illuminate\Http\Request;

class TeacherScheduleController extends TeacherBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        Html::loadFileupload();
        Html::loadDatepicker();
        $this->layout->content  =  view('teacher.teacher_schedule');
        Html::instance()->addScript( 'public/app/teacher/teacher_schedule.js' );
        return $this->layout;
    }



}
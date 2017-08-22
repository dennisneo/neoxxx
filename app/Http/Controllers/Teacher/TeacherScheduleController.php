<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Users\UserEntity;
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

        //$this->layout->content  =  view('teacher.teacher_schedule');
        //Html::instance()->addScript( 'public/app/teacher/teacher_schedule.js' );

        $this->layout->content      =  view('admin.schedules.admin_schedules' , ['teacher_id' => UserEntity::me()->id ]);
        Html::instance()->addScript( 'public/app/admin/schedules/admin_schedules.js' );
        return $this->layout;

    }



}
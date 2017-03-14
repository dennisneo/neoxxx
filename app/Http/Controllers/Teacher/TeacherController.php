<?php

namespace App\Http\Controllers\Teacher;

use App\Models\ClassSessions\ClassSessionEntity;
use App\Models\Users\TeacherEntity;
use App\Models\Users\UserEntity;
use Helpers\Html;
use Illuminate\Http\Request;

class TeacherController extends TeacherBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function classSession( ClassSessionEntity $class )
    {
        Html::loadFileupload();
        $class  = $class->vuefy();
        $this->layout->content  =  view('teacher.teacher_class' , compact( 'class' ));
        Html::instance()->addScript( 'public/app/teacher/teacher_class.js' );
        return $this->layout;
    }
    /**
     * @param Request $r
     * @return mixed
     */
    public function schedule( Request $r )
    {
        Html::loadFileupload();
        Html::loadDatepicker();

        //$this->layout->content      =  view('teacher.teacher_schedule');
        //Html::instance()->addScript( 'public/app/teacher/teacher_schedule.js' );

        $this->layout->content      =  view('admin.schedules.admin_schedules' , [ 'teacher_id' => UserEntity::me()->id ] );
        Html::instance()->addScript( 'public/app/admin/schedules/admin_schedules.js' );

        return $this->layout;
    }


    /**
     * evaluation made by students
     */
    public function evaluation( Request $r )
    {
        $this->layout->content  =  view('teacher.teacher_evaluation');
        Html::instance()->addScript( 'public/app/teacher/teacher_evaluation.js' );
        return $this->layout;
    }

    /**
     * evaluation made by students
     */
    public function contact( Request $r )
    {
        $this->layout->content  =  view('teacher.teacher_contact');
        return $this->layout;
    }

    /**
     * salary view
     */
    public function salary( Request $r )
    {
        $teacher = UserEntity::me();
        $this->layout->content  =  view('teacher.teacher_salary' , compact( 'teacher' ));
        Html::instance()->addScript( 'public/app/teacher/teacher_salary.js' );
        return $this->layout;
    }

    public function performance( Request $r )
    {
        $this->layout->content  =  view('teacher.teacher_performance' , [ 'teacher' => $r->user() ] );
        Html::instance()->addScript( 'public/app/teacher/teacher_performance.js' );
        return $this->layout;
    }

    public function profile( Request $r )
    {
        //$teacher = TeacherEntity::find( UserEntity::me()->id )->vuefyTeacher();
        $teacher = ( new TeacherEntity )->getByUserId( UserEntity::me()->id )->vuefyTeacher();

        $this->layout->content  =  view('teacher.teacher_profile' , [ 't' => $teacher ] );
        Html::instance()->addScript( 'public/app/teacher/teacher_profile.js' );
        Html::loadDateCombo();
        Html::loadFileupload();
        return $this->layout;
    }

}
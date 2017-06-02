<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Teacher\TeacherBaseController;
use App\Models\Users\TeacherEntity;
use App\Models\Users\TeacherPivot;
use Helpers\Html;
use Illuminate\Http\Request;

class AdminTeachersController extends AdminBaseController{

    public function __construct()
    {
        parent::__construct();
        Html::loadToastr();
    }

    public function index()
    {
        $this->layout->content = view('admin.teachers.teachers_index');
        Html::instance()->addScript( 'public/app/admin/teachers/teachers.js' );
        Html::loadDatepicker();

        return $this->layout;
    }

    public function teacher( $id , Request $r )
    {
        $a = TeacherEntity::find( $id );
        $this->layout->content = view('admin.teachers.teacher_view', [ 'a' => $a ]);
        Html::instance()->addScript( 'public/app/admin/teachers/teacher.js' );
        return $this->layout;
    }

    public function editTeacherProfile( $id , Request $r )
    {
        $u = TeacherEntity::find( $id );
        $p = TeacherPivot::byUserId( $id );

        $this->layout->content = view('admin.teachers.teacher_edit', compact( 'u' , 'p') );

        Html::instance()->addScript( 'public/app/admin/teachers/teacher_edit.js' );
        Html::instance()->addScript( '/public/plugins/validation/jqBootstrapValidation.js' );
        Html::loadDateCombo();
        return $this->layout;
    }

    public function performanceRecords()
    {
        $this->layout->content = view('admin.teachers.teacher_performance_records', []);
        Html::instance()->addScript( 'public/app/admin/teachers/teacher_records.js' );
        Html::loadDatepicker();
        Html::loadAutoComplete();
        return $this->layout;
    }

    public function manageTeacherSchedule( $teacher_id , Request $r )
    {
        if( ! $t = TeacherEntity::find( $teacher_id ) ){
             // send to error page
        }
        $t->vuefyTeacher();

        //dd(  date( 'Y-m-d H:i:s', strtotime('next Mon' )  ) );

        $this->layout->content = view('admin.teachers.teacher_schedule', [ 't' => $t ]);

        Html::loadFullCalendar();
        Html::loadDateCombo();
        Html::instance()->addScript( 'public/app/admin/teachers/teacher_schedule.js' );

        return $this->layout;
    }

}
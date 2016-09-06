<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Users\Applicant;
use App\Models\Users\TeacherEntity;
use App\Models\Users\Teachers;
use Illuminate\Http\Request;

class AjaxTeachersController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function getTeachers( Request $r )
    {
        $teachers  = new Teachers();
        return [
            'success' => true,
            'teachers' => $teachers->vuefyAll( $teachers->getTeachers( $r ) )
        ];
    }

    public function saveTeacher( Request $r )
    {
        $teacher = new TeacherEntity();
        if( ! $teacher->store( $r ) ){
            return [
                'success' => false,
                'message' => $teacher->displayErrors()
            ];
        }

        return [
            'success' => true,
            'teacher' => $teacher
        ];
    }
}
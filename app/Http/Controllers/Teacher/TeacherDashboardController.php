<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Users\UserEntity;
use Helpers\Html;
use Illuminate\Http\Request;

class TeacherDashboardController extends TeacherBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index( Request $r )
    {
        $teacher = UserEntity::me();
        $this->layout->content  =  view('teacher.teacher_dashboard',
            ['t' => $teacher ]
        );
        return $this->layout;
    }

}
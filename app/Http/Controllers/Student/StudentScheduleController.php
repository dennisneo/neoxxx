<?php

namespace App\Http\Controllers\Student;

use App\Models\Users\TeacherEntity;
use App\Models\Users\Teachers;
use Helpers\Html;
use Helpers\Text;
use Illuminate\Http\Request;

class StudentScheduleController extends StudentBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->indexAssets();
        $this->layout->content = view( 'student.student_schedule' );
        return $this->layout;
    }

    private function indexAssets()
    {
        Html::loadToastr();
        Html::instance()->addScript( '/public/app/student/student_dashboard.js' );
    }

}
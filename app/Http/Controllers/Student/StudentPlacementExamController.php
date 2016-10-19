<?php

namespace App\Http\Controllers\Student;

use App\Models\ClassSessions\ClassFeedback;
use Helpers\Html;

class StudentPlacementExamController extends StudentBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $this->indexAssets();
        $this->layout->content = view( 'student.student_placement_exam' );
        return $this->layout;
    }

    private function indexAssets()
    {
        Html::instance()->addScript( '/public/app/student/student_placement_exam.js' );
    }

}
<?php

namespace App\Http\Controllers\Student;

use App\Models\ClassSessions\ClassFeedback;
use Helpers\Html;
use Illuminate\Http\Request;

class StudentPlacementExamController extends StudentBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(  Request $r )
    {
        $this->indexAssets();
        $this->layout->content = view( 'student.student_placement_exam' , [ 'r' => $r ] );
        return $this->layout;
    }

    public function start( Request $r )
    {
        Html::instance()->addScript( '/public/app/student/student_placement_exam.js' );
        $this->layout->content = view( 'student.pe.pe_intro' , [ 'r' => $r ] );
        return $this->layout;
    }

    private function indexAssets()
    {
        //Html::instance()->addScript( '/public/app/student/student_placement_exam.js' );
    }

}
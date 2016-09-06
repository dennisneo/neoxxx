<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Users\Applicant;
use App\Models\Users\Students;
use App\Models\Users\Teachers;
use Illuminate\Http\Request;

class AjaxStudentsController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function getAvailableTeachers( Request $r )
    {
        $teachers = new Teachers;
        $r->request->add(['is_active' => true ]);

        $t_arr = $teachers->vuefyAll( $teachers->getTeachers( $r ) );

        return [
            'success' => true,
            'teachers' =>  $t_arr
        ];

    }

    public function getStudents( Request $r )
    {
        $students  = new Students();
        return [
            'success' => true,
            'students' => $students->vuefyAll( $students->getStudents( $r ) )
        ];
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Ajax\Student;


use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\ClassSessions\ClassSessions;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Users\Applicant;
use Illuminate\Http\Request;

class AjaxStudentController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function saveClassSession( Request $r )
    {

        $s = new ClassSessions();
        $s->store( $r );

        return [
            'success' => true,
            'sid' => 1
        ];
    }
}
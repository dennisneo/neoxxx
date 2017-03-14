<?php

namespace App\Http\Controllers\Student;


use Illuminate\Http\Request;

class StudentPaymentsController extends StudentBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function history( Request $r )
    {
        $this->layout->content = view( 'student.payment_history' );
        return $this->layout;
    }

}
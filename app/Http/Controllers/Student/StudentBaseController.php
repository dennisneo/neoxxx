<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Users\UserEntity;

class StudentBaseController extends Controller{

    public function __construct()
    {
        parent::__construct();
        // check user if  student
        $this->checkUser();
    }

    private function checkUser()
    {
        if( \Auth::check() ){
            if(  \Auth::user()->user_type != 'student' ){
                \Session::flash( 'message', trans( 'general.invalid_credentials') );
                redirect('login')->send();
            }

            $user = UserEntity::find( \Auth::user()->id );
            UserEntity::setupMe( $user ) ;

            return;
        }

        redirect('login')->send();
    }

}
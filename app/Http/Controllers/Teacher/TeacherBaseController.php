<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Users\UserEntity;

class TeacherBaseController extends Controller{

    public function __construct()
    {
        parent::__construct();
        // check user if teacher
        $this->checkUser();
    }

    private function checkUser()
    {
        if( \Auth::check() ){
            if(  \Auth::user()->user_type != 'teacher' ){
                redirect('login')->send();
            }

            $user = UserEntity::find( \Auth::user()->id );
            UserEntity::setupMe( $user ) ;

            return;
        }

        redirect('login')->send();
    }

}
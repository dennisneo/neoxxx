<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Users\UserEntity;

class AdminBaseController extends Controller{

    public function __construct()
    {
        parent::__construct();
        // check user if admin
        $this->checkUser();
    }

    private function checkUser()
    {
        if( \Auth::check() ){

            if(  \Auth::user()->user_type != 'admin' ){
                redirect('login')
                    ->send();
            }

            $user = UserEntity::find( \Auth::user()->id );
            UserEntity::setupMe( $user ) ;

            return true;
        }

        redirect('login')->send();
    }

}
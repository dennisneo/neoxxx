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
        // check user
        $this->checkUser();
        $this->setupLayout();

    }


    private function setupLayout( $theme = null )
    {
        $this->theme = $theme ? $theme : env( 'APP_THEME' );
        $this->theme_path = __DIR__.'/../../Views/themes/'.$this->theme.'/';

        /***
         * setup the view files
         */
        view()->addLocation( $this->theme_path );

        $this->layout = view( 'layouts.'.$this->theme.'_default' );
    }

    private function checkUser()
    {
        if( \Auth::check() ){
            if(  \Auth::user()->user_type != 'admin' ){
                redirect('login')
                    ->withInput('error' , 'User is not an admin')
                    ->send();
            }

            $user = UserEntity::find( \Auth::user()->id );
            UserEntity::setupMe( $user ) ;

            return;
        }

        redirect('login')
            ->send();
    }

}
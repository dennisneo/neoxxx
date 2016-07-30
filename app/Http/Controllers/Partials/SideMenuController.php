<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/30/2016
 * Time: 10:07 AM
 */

namespace App\Http\Controllers\Partials;

use App\Http\Controllers\Controller;
use App\Models\Users\UserEntity;

class SideMenuController extends  Controller{

    public static function displaySidebar( UserEntity $user )
    {
        $theme = env('APP_THEME');
        $theme_path = __DIR__.'/../../Views/themes/'.$theme.'/partials/sidebars/';
        view()->addLocation( $theme_path );
        $user_type = strtolower( str_replace( ' ', '_' , $user->user_type ) );

        return view( $user_type.'_sidemenu' );
    }
}
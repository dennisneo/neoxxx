<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers;

use App\Http\Models\Locations\Countries;
use App\Models\Users\Applicant;
use App\Models\Users\User;
use App\Models\Users\UserEntity;
use Helpers\Html;
use Illuminate\Http\Request;

class UtilsController extends Controller{

    public function __construct()
    {

    }

    public function pwd()
    {
        /**
        $user  = UserEntity::find( 20 );
        $params = unserialize( $user->params );
        $pwd  = $user->getPassword( $params['pwd']);
         **/
        $pwd = 'arfarf';
        dd( \Hash::make( $pwd ) );

    }
}
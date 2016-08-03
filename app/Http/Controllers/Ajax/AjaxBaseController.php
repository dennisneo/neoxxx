<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Ajax;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxBaseController extends Controller{

    protected  $user;

    public function __construct( Request $r )
    {
        if( ! $r->ajax() ){
            // do nothing when accessed out of ajax call
            exit;
        }

        // TODO check if user is an admin or not

        // check auth middleware here
        if( ! $this->user = $this->setUser() ){

        }
    }

}
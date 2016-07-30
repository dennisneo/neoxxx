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

    public function __construct( Request $r )
    {
        if( ! $r->ajax() ){
            exit;
        }
    }

}
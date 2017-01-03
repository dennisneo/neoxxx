<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;

class AjaxUtilsController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function timeSelect( Request $r )
    {
        $s = strtotime( $r->s );
        //$e = date( 'Y-m-d H:i:s', strtotime( $r->e ) );
        $e = strtotime( $r->e );
        $s_array = [];
        for( $i = $s ; $i <= ( $e - 1200 ) ; $i = $i+600 ){
            $max_min = $e - $i;
            $s_array[]  = ['dt' => date( 'h:i a', $i ) , 'max'=> $max_min ];

        }

        return [
            'success' =>true,
            's'=> $s_array,
        ];
    }

}

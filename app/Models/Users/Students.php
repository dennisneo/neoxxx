<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Students extends StudentEntity{

    public function getStudents( Request $r )
    {
        $limit  = $r->limit ? $r->limit : 50;
        $page   = $r->page ? $r->page : 1;
        $offset = ( $r->page - 1 ) * $limit;
        $order_by  = $r->orderby ? $r->orderby : 'created_at';
        $direction = $r->direction ? $r->direction : 'DESC';

        $t = static::where( 'user_type' , 'student' );

        if( $r->q ){
            $t->whereRaw( " MATCH( first_name, last_name ) against (? in boolean mode)" , [$r->q] );
            $fields[] = \DB::raw(" MATCH( first_name, last_name ) against ( '$r->q' ) as score ");
        }


        $this->total = $t->count();

        $t->limit( $limit );
        $t->offset( $offset );
        $t->orderby( $order_by , $direction );

        return $t->get();
    }

    public function vuefyAll( Collection $students )
    {
        $t_arr  = [];
        foreach( $students as $t ){
            $t_arr[] = $t->vuefyStudent();
        }

        return $t_arr;
    }

    public function getErrors()
    {
        return $this->errors;
    }



}
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

        $t = static::where( 'user_type' , 'student' );

        $this->total = $t->count();

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
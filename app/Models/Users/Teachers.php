<?php

namespace App\Models\Users;

use App\Models\ClassSessions\ClassSessions;
use Illuminate\Http\Request;

class Teachers extends TeacherEntity{

    public static function getAvailableTeachers( $start_time )
    {
        $weekday    = strtolower( date( 'D', strtotime( $start_time )) );
        $hr = date( 'H', strtotime( $start_time ));
        $min = date( 'i', strtotime( $start_time ));
        $min_of_day =  ( $hr * 60 ) + $min;

        $teachers = static::where( 'weekday', $weekday  )->where( 'from_time' , '<=' , $min_of_day )
            ->from( 'teachers_schedule as ts')
            ->where( 'to_time', '>=' , $min_of_day )
            ->join( 'users as u' ,'u.id' ,'=','ts.teacher_id'  )
            ->get( ['id' , 'first_name' , 'last_name' , 'profile_photo_url'] );

        return $teachers;
    }

    public function getTeachers( Request $r )
    {
        $limit  = $r->limit ? $r->limit : 50;
        $page   = $r->page ? $r->page : 1;
        $offset = ( $r->page - 1 ) * $limit;
        $fields = [ 'u.*' ];

        $t = static::where( 'user_type' , 'teacher' )
         ->from( 'users as u')
         ->with( 'details' );
         //->join( 'teachers as t', 't.user_id' , '=', 'u.id' , 'LEFT');

        if( isset( $r->is_active ) ){
            $t->where( 'is_active' , $r->is_active );
        }

        if( $r->q ){
            $t->whereRaw( " MATCH( first_name, last_name ) against (? in boolean mode)" , [$r->q] );
            $fields[] = \DB::raw(" MATCH( first_name, last_name ) against ( '$r->q' ) as score ");
            /**
            $t->where( function( $q ) use ( $r ) {
                $q->where( 'first_name' , 'like' , $r->q.'%')
                  ->orWhere( 'last_name' , 'like' , $r->q.'%' );
            });
             * **/
        }

        $this->total = $t->count();
        $this->collection =  $t->get( $fields );

        return $this->collection;
    }

    public function vuefyAll( $teachers )
    {
        $t_arr  = [];
        foreach( $teachers as $t ){
            $t_arr[] = $t->vuefyTeacher();
        }

        return $t_arr;
    }

    public function vuefy()
    {
        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getTotal()
    {
        return $this->total;
    }

}
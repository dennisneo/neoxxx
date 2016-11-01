<?php

namespace App\Models\Users;

use App\Models\BaseModel;

class TeacherPivot extends BaseModel{

    public $table       = 'teachers';
    public $primaryKey  = 'map_id';

    public $timestamps = false;

    public static function getByTeacherId( $teacher_id , $create_new = true )
    {
         $teacher = static::where( 'user_id' , $teacher_id )
            ->first();

         if( ! $teacher ){
           // create new entry for teacher if none is found
            if( $create_new ){
                $t  = new static;
                $t->user_id = $teacher_id;
                $t->save();

                return $t;
            }
         }

         return $teacher;
    }


}
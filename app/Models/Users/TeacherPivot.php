<?php

namespace App\Models\Users;

use App\Models\BaseModel;
use Illuminate\Http\Request;

class TeacherPivot extends BaseModel{

    public $table       = 'teachers';
    public $primaryKey  = 'map_id';

    public $timestamps = false;

    protected  $fillable = [ 'rating', 'about', 'voice_url', 'type' ];

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

    public static function byUserId( $user_id )
    {
        return static::where( 'user_id' , $user_id )->first();
    }

    public function store( Request $r )
    {
        $validator = \Validator::make( $r->all() , [
            // validation rules here
        ] );

        if( $validator->fails() ){
            $this->errors = $validator->errors()->all();
            return false;
        }

        $this->fill( $r->all() );
        $pk = $this->primaryKey;

        if( $r->$pk  ){
            $this->exists = true;
        }else{

        }

        $this->save();

        return $this;
    }



}
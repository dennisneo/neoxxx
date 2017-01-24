<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Users;

use App\Models\Users\Students\StudentCredits;
use Illuminate\Http\Request;
use Validator;

class StudentEntity extends UserEntity{

    /**
     * @param $user_id
     * @return StudentEntity
     **/
    public function getByUserId( $user_id )
    {
        $student = static::where( 'id' , $user_id )
            ->from( 'users as u')
            //->leftJoin( 'teachers as t', 't.user_id' ,'=' ,'u.id' )
            ->first();

        if( ! $student ){
             return new static;
        }

        return $student->vuefyStudent();
    }

    public function addCredits( $value  = 0)
    {
        // cannot add credit withour student id
        if( !$this->id ){
            return false;
        }

        $scredits   =   StudentCredits::where( 'student_id' , $this->id )->first();
        if( $scredits ){
            $scredits->credits = $scredits->credits + $value;
        }else{
            $scredits =  new StudentCredits();
            $scredits->student_id = $this->id;
            $scredits->credits = $value;
        }

        $scredits->save();

        return $scredits;
    }

    public static function rules( $exists = false )
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            //'qq' => 'required'
        ];

        $rules['email'] = $exists ? 'email' : 'email|unique:users';

        return $rules;
    }


    public function vuefyStudent()
    {
        $this->vuefyUser();
        return $this;
    }


}
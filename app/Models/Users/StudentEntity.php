<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Users;

use Illuminate\Http\Request;
use Validator;

class StudentEntity extends UserEntity{

    public static function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|unique:users',
            'qq' => 'required'
        ];
    }


    public function vuefyStudent()
    {
        $this->vuefyUser();
        return $this;
    }
}
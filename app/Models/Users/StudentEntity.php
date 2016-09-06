<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Users;

use Illuminate\Http\Request;

class StudentEntity extends UserEntity{

    public function vuefyStudent()
    {
        $this->vuefyUser();
        return $this;
    }
}
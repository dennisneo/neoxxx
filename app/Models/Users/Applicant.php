<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Users;

use Illuminate\Foundation\Validation\ValidatesRequests;

class Applicant extends UserEntity{
    use ValidatesRequests;


    public function getErrors()
    {
        return $this->errors;
    }

}
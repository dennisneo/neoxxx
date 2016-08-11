<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Users;

use Illuminate\Http\Request;

class Students extends StudentEntity{

    public function getErrors()
    {
        return $this->errors;
    }



}
<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Users;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class Applicants extends UserEntity{
    use ValidatesRequests;


    public function getErrors()
    {
        return $this->errors;
    }

    public function getAllApplicants( Request $r )
    {
        $order_by  = $r->orderby ? $r->orderby : 'created_at';
        $direction = $r->direction ? $r->direction : 'DESC';

        $applicants = static::where('user_type' , 'applicant')
        ->orderby( $order_by , $direction );

        return $applicants->get();
    }

}
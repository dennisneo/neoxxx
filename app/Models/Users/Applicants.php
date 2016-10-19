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
        $limit = $r->limit ? $r->limit : 20;
        $page = $r->page ? $r->page : 1;
        $offset = ( $page-1 ) * $limit;
        $order_by  = $r->orderby ? $r->orderby : 'created_at';
        $direction = $r->direction ? $r->direction : 'DESC';

        $applicants = static::where( 'user_type' , 'applicant');

        $this->total = $applicants->count();

        $applicants->orderby( $order_by , $direction );
        $applicants->limit( $limit );

        return $applicants->get();
    }

}
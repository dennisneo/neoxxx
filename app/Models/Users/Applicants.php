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

        $fields = [ 'u.*' ];
        $applicants = static::where( 'user_type' , 'applicant')
         ->from( 'users as u' );

        if( $r->q ){
            $applicants->whereRaw(" MATCH( first_name, last_name ) against (? in boolean mode)", [$r->q] );
            $fields[] = \DB::raw(" MATCH( first_name, last_name ) against ( '$r->q' ) as score ");
        }

        if( $r->status ){
            $applicants->where( 'u.status' , $r->status );
        }

        $this->total = $applicants->count();

        $applicants->orderby( $order_by , $direction );
        $applicants->limit( $limit );

        return $applicants->get( $fields );
    }

}
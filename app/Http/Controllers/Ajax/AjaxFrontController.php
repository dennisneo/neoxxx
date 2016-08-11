<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Ajax;


use App\Models\Users\Applicants;
use Helpers\Text;
use Illuminate\Http\Request;

class AjaxFrontController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function saveApplication( Request $r )
    {
        $r->request->add( [ 'user_type' => 'applicant' ] );
        $applicant = new Applicants();
        if( ! $a = $applicant->store( $r ) ){
            return [
                'success' => false,
                'message' => $applicant->getErrors()
            ];
        }

        // do notify admins here
        $e = collect( str_split( $a->password))->every( 5 );
        return [
            'success' => true,
            'uid' => Text::convertInt( $a->id ),
            'e' => $e
        ];
    }
}

<?php

namespace App\Http\Controllers\Common;




use App\Models\Users\Applicants\ApplicantRequirements;
use Helpers\Text;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CommonController extends Controller{

    public function downloadCv( $applicant_id )
    {
        $applicant_id = Text::recoverInt( $applicant_id  );

        $req = ApplicantRequirements::record( $applicant_id );

        if( ! $req->cv ){
            return 'Nothing to download!';
        }

        $upath = env( 'APP_URL' ).'/'.env( 'SUBDIR' );
        $path = str_replace(  $upath , public_path() , $req->cv  );

        /**
         * force download a file
         */
        return response()->download( $path );
    }

}
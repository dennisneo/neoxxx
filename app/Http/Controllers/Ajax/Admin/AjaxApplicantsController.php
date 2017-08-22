<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\Users\Applicants;
use App\Models\Users\UserEntity;
use App\Models\Utilities\Modifications;

use Helpers\Text;
use Illuminate\Http\Request;

class AjaxApplicantsController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function uploadCv( Request $r )
    {

        $req     = Applicants\ApplicantRequirements::record( $r->applicant_id );

        if( ! $req ){
            // check if user is an applicant
            $applicant = UserEntity::find( $r->applicant_id );

            if( $applicant->user_type != 'applicant'){
                return [
                    'success' => false,
                    'message' => 'Invalid applicant id'
                ];
            }

            // create an applicant requirement entry
            $req = new Applicants\ApplicantRequirements();
            $req->store(  $r );

        }

        if( $r->hasFile('cv') ){

            $ext = $r->file( 'cv' )->getClientOriginalExtension();

            $orig_filename = $r->file( 'cv' )->getClientOriginalName();
            $new_filename = 'cv.'.$ext;

            $destination = '/public/images/users/'.Text::convertInt( $r->applicant_id ).'/';
            $url = url( $destination.$new_filename );

            $destination  = public_path().''.$destination;

            if( ! is_dir( $destination )){
                mkdir( $destination , 755 , true );
            }

            $r->file( 'cv' )->move( $destination , $new_filename );
            $file_path = $destination.$new_filename;

            $req->cv = $url;
            $req->save();

            return [
                'success' => true,
                'req' => $req
            ];
        }

        return [
            'success' =>true,
            'applicant_id' => $r->applicant_id
        ];
    }

    public function saveRequirements( Request $r )
    {
        // check if applicant has data in applicant_requirement table
        $req = Applicants\ApplicantRequirements::record( $r->applicant_id );
        $req->store( $r );

        return [
            'success' =>true,
            'req' => $req
        ];
    }

    public function getApplicants( Request $r )
    {
        $a = new Applicants();
        $applicants = $a->getAllApplicants( $r );

        return [
            'success' => true,
            'applicants' => $applicants
        ];
    }

    public function updateStatus( Request $r )
    {
        $user = UserEntity::find( $r->user_id );
        $um_user = $user;

        switch( $r->status ){
            case 'promoted':
                $user->user_type = 'teacher';
                $user->status = 'level 1';
                $user->save();

                // send email containing access details to new teacher
                $this->sendApplicantEmail( $user );

            break;
            case 'archive':
                $user->status = 'archived';
                $user->save();
            break;

        }

        Modifications::add(
            [
                'attribute' => 'user_type',
                'entity'    => 'user',
                'entity_id' => $r->user_id,
                'old_value' => $um_user->user_type,
                'new_value' => $user->user_type
            ]
        );

        return [
            'success' => true,
            'user_type' => $user->user_type
        ];
    }

    /**
     * email sent when the applicant was promoted to teacher
     */
    private function sendApplicantEmail( UserEntity $user )
    {

        view()->addLocation( app_path().'/Http/Views/emails' );

        \Mail::send( 'applicant_promoted_to_teacher', ['user' => $user],
            function ($m) use ($user) {
                $m->from( env( 'APP_EMAIL_SENDER' )   );
                $m->to( $user->email, $user->displayName() )
                    ->subject( trans( 'general.teacher_promoted_email_subject' ) );
            }
        );

    }
}
<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\Users\Applicants;
use App\Models\Users\UserEntity;
use App\Models\Utilities\Modifications;

use Illuminate\Http\Request;

class AjaxApplicantsController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
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
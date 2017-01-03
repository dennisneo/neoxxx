<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Messaging\Notes;
use App\Models\Users\Applicants\ApplicantRequirements;
use Illuminate\Http\Request;

class AjaxCommonController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function saveNote( Request $r )
    {
        $r->request->add([
            'posted_by' => $r->user()->id
        ]);

        $note = new Notes();
        $note->store( $r );

        return [
            'success' =>true,
            'note' => $note->retrieveRelationships()->vuefy(),
        ];
    }

    public function getNotes( Request $r )
    {
        $notes = Notes::byUserId( $r->aid , $r );

        return [
            'success' =>true,
            'notes' => $notes->vuefyNotesCollection()
        ];
    }

    public function getApplicantRequirements( Request $r )
    {
        $req = ApplicantRequirements::where( 'applicant_id' , $r->aid )
            ->first();

        return [
            'success' =>true,
            'req' => $req
        ];
    }

}

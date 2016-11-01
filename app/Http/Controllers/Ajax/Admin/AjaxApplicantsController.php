<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Placement\QuestionChoices;
use App\Models\Placement\Questions;
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

    public function saveRequirements( Request $r )
    {
        return [
            'success' =>true
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
            break;
            case 'archive':
                $user->status = 'archived';
                $user->save();
            break;

        }

        Modifications::add(
            [
                'attribute' => 'status',
                'entity'    => 'user',
                'entity_id' => $r->user_id,
                'old_value' => $um_user->status,
                'new_value' => $user->status,
            ]
        );

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


}
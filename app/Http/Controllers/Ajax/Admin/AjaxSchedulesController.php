<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\ClassSessions\ClassSessions;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Users\Applicant;
use App\Models\Users\Students;
use App\Models\Users\Teachers;
use App\Models\Users\UserEntity;
use Illuminate\Http\Request;

class AjaxSchedulesController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function getSchedules( Request $r )
    {

        if( $r->tid ){
            $user = UserEntity::find( $r->tid );
        }else{
            $user = UserEntity::find( $r->sid );
        }

        /**
        if( ! $user ){
            return [
                'success' =>false,
                'message' => 'User not found'
            ];
        }
        ***/

        $cs = new ClassSessions;
        $sessions =  $cs->getAll( $r );

        return [
            'success' => true,
            'sessions' => $sessions,
            'total' => $cs->getTotal(),
            'page_count' => $cs->getPageCount( true )
        ];
    }
}
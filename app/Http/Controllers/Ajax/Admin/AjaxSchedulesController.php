<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Events\CancelClassSessionEvent;
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
    
    public function cancelSched( Request $r )
    {

        $session = ( new ClassSessions )->find( $r->sched_id );

        if( ! $session ){
            return [
                'success' => false,
                'message' => 'Class session not found'
            ];
        }

        $session->class_status = 'cancelled';
        $session->save();

        $cs = new ClassSessions;
        $r->merge(['class_id'=> $session->class_id ]);
        $sessions =  $cs->getAll( $r );

        // email both teacher and user of the cancellation
        event( new CancelClassSessionEvent( $session ));


        return [
            'success' => true,
            'session' => $sessions[0]
        ];

    }

}
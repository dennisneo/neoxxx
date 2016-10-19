<?php

namespace App\Http\Controllers\Ajax\Teacher;

use App\Events\CancelClassSessionEvent;
use App\Events\NewClassSession;
use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\ClassSessions\ClassSessionEntity;
use App\Models\ClassSessions\ClassSessions;
use App\Models\Financials\Credits;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Performance\TeacherPerformance;
use App\Models\Users\Applicant;
use App\Models\Users\StudentEntity;
use App\Models\Users\TeacherEntity;
use App\Models\Users\Teachers;
use Helpers\Text;
use Illuminate\Http\Request;
use Event;

class AjaxTeacherController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }


    public function getTeacherSchedule( Request $r )
    {
        $sessions = ( new ClassSessions )->byTeacherId( $r );

        return [
            'success' => true,
            'sessions' => $sessions
        ];
    }

    public function getClassRecord( Request $r )
    {
        if( ! $class  = ClassSessionEntity::find( $r->cid ) ){
            return [
                'success' => false,
                'message' => 'Invalid class id'
            ];
        }
        if( ! $class->canEdit() ){
            return [
                'success' => false,
                'message' => 'Access to class denied'
            ];
        }
        
        return [
            'success' => true,
            'session' => $class->vuefy()
        ];
    }

    public function updateClassRecord( Request $r )
    {
        $sessions = ClassSessions::find( $r->class_id );

        if( ! $sessions->updateRecord( $r ) ){
            return [
                'success' => false,
                'message' => $sessions->displayErrors()
            ];
        }

        return [
            'success' => true,
            'sessions' => $sessions

        ];
    }

    public function deleteAudioFile( Request $r )
    {
        $class_id = Text::recoverInt( $r->ccid );
        if( ! $sessions = ClassSessions::find( $class_id ) ){
            return [
                'success' => false,
                'message' => $sessions->displayErrors()
            ];
        }

        $sessions->audio_file = '';
        $sessions->save();

        return [
            'success' => true,
            'sessions' => $sessions

        ];
    }

    public function getPerformanceRecord( Request $r )
    {
        $records = ( new TeacherPerformance )->getAll( $r );

        return [
            'success' => true,
            'records' => $records
        ];

    }
    
    public function savePerformanceRecord( Request $r )
    {
        $p = new TeacherPerformance;
        if( ! $p->store( $r ) ){
            return [
                'success' =>false,
                'messsage' => $p->displayErrors()
            ];
        }

        return [
            'success' => true,
            'record' => $p->vuefy()
        ];
    }

    public function uploadAudio( Request $r )
    {

        if( ! $class = ClassSessionEntity::find( $r->class_id ) ){
            return [
                'success' =>   false,
                'message' =>   'Invalid class id'
            ];
        }

        if( $r->hasFile('audio') ){

            if (! $r->file('audio')->isValid()) {
                return [
                    'success' =>   false,
                    'message' =>   'File not valid'
                ];
            }


            if( ! $class->uploadAudio( $r ) ){
                return [
                    'success' => false,
                    'message' => $class->displayErrors()
                ];
            }

            return [
                'success' =>true,
                'session' => $class->vuefy()
            ];
        }

        return [
            'success' => false,
            'message' => 'Audio file not found'
        ];
    }

}
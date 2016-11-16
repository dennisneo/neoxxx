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
use App\Models\Users\TeacherPivot;
use App\Models\Users\Teachers;
use App\Models\Users\UserEntity;
use Helpers\Text;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Event;

class AjaxTeacherController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function getUpcomingClass( Request $r )
    {
        $r->request->add( ['tid'=>UserEntity::me()->id]);
        $cs = new ClassSessions;
        $classes = $cs->byTeacherId( $r );

        return [
            'success' => true,
            'classes' => $classes
        ];
    }

    public function updateAbout( Request $r )
    {
        $user = UserEntity::me();
        $teacher = TeacherPivot::where('user_id' , $user->id  )->first();
        if( ! $teacher ){
            return [
                'success' =>false,
                'message' => 'Cannot update write-up. Teacher not found'
            ];
        }
        $teacher->about = $r->about;
        $teacher->save();

        return [
            'success' =>true,
            'about' => $r->about
        ];
    }

    public function uploadVoice( Request $r )
    {
        if( ! $teacher = TeacherEntity::find( UserEntity::me()->id ) ){
            return [
                'success' => false,
                'message' => 'Invalid user id'
            ];
        }

        if( $teacher->user_type != 'teacher' ){
            return [
                'success' => false,
                'message' => 'Only teachers are allowed to upload voice files'
            ];
        }

        if( $r->hasFile('audio') ){

            if (! $r->file('audio')->isValid()) {
                return [
                    'success' =>   false,
                    'message' =>   'File not valid'
                ];
            }

            $user = UserEntity::me();

            if( ! $url = $teacher->uploadVoice( $r ) ){
                return [
                    'success' => false,
                    'message' => $user->displayErrors()
                ];
            }

            return [
                'success' =>true,
                'url' => $url
            ];
        }

        return [
            'success' => false,
            'message' => 'Audio file not found'
        ];
    }

    public function deleteVoice( Request $r ){

        $user_id = Text::recoverInt( $r->cid );

        $teacher = TeacherPivot::where('user_id' , $user_id  )
            ->first();
        if( ! $teacher ){
            return [
                'success' =>false,
                'message' => 'Cannot delete audio file. Teacher not found'
            ];
        }

        $teacher->voice_url = '';
        $teacher->save();

        return [
            'success' =>true
        ];

    }

    public function uploadProfilePhoto( Request $r )
    {
        if( $r->hasFile('photo') ){

            if (! $r->file('photo')->isValid()) {
                return [
                    'success' =>   false,
                    'message' =>   'File not valid'
                ];
            }

            $user = UserEntity::me();


            if( ! $user->uploadProfilePhoto( $r ) ){
                return [
                    'success' => false,
                    'message' => $user->displayErrors()
                ];
            }

            return [
                'success' =>true,
                'user' => $user->vuefy()
            ];
        }

        return [
            'success' => false,
            'message' => 'Uploaded file not found'
        ];

    }

    public function saveProfile( Request $r )
    {
        $teacher = new TeacherEntity();

        if( ! $teacher->store( $r ) ){
            return [
                'success' =>false,
                'message' => $teacher->displayErrors()
            ];
        }

        return [
            'success' =>true
        ];
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
        $sessions = ClassSessionEntity::find( $r->class_id );

        if( ! $s  = $sessions->updateRecord( $r ) ){
            return [
                'success' => false,
                'message' => $sessions->displayErrors()
            ];
        }

        return [
            'success' => true,
            'n' => 1,
            'sessions' => $s->vuefy()

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
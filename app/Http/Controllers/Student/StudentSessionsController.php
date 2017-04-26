<?php

namespace App\Http\Controllers\Student;

use App\Models\ClassSessions\ClassSessions;
use App\Models\Users\Teachers;
use Helpers\Html;
use Helpers\Text;
use Illuminate\Http\Request;

class StudentSessionsController extends StudentBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $r
     * @return static
     */
    public function newSession( Request $r )
    {
        $cid = Text::recoverInt( $r->cid );

        if( ! $class_session = ( new ClassSessions)->getClassSession( $cid ) ){
            // redirect somewhere
            session()->flash( 'error_message' , trans( 'general.invalid_class_session'));
            return redirect( '' );
        }

        $class_session->vuefy();
        $this->newSessionAssets();

        $this->layout->content = view( 'student.student_session' )
        ->with( 'cs' , $class_session );

        return $this->layout;

    }

    /**
     * shows after successfully enrolling a class
     *
     * @param Request $r
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function classSessionDetails( Request $r )
    {
        $cid = Text::recoverInt( $r->cid );
        if( ! $class_session = ( new ClassSessions )->getClassSession( $cid ) ){
            // redirect somewhere
            session()->flash( 'error_message' , trans( 'general.invalid_class_session'));
            return redirect( 'student/dashboard' );
        }

        $class_session->vuefy();

        $this->layout->content = view( 'student.class_details' )
            ->with( 'cs' , $class_session );

        return $this->layout;
    }

    private function newSessionAssets()
    {
        Html::loadDateCombo();
        Html::loadDatepicker();
        Html::loadToastr();

        Html::instance()->addScript( '/public/app/student/student_session.js' );
    }

}
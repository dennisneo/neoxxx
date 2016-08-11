<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers;

use App\Http\Models\Locations\Countries;
use App\Models\Users\Applicant;
use App\Models\Users\Applicants;
use App\Models\Users\StudentEntity;
use App\Models\Users\User;
use App\Models\Users\UserEntity;
use Helpers\Html;
use Helpers\Text;
use Illuminate\Http\Request;

class FrontController extends Controller{

    public function __construct()
    {
        // frontend theme is called agency
        parent::__construct( 'agency' );
    }

    public function login( Request $r )
    {
        $error = session('message') ? session('message') : null;

        if( $r->isMethod( 'post' ) ){

            if( $user = \Auth::attempt( array( 'username' => $r->username, 'password' => $r->pwd  )  ) ){

                // log the login details
                //Logins::log( \Auth::user()->id );

                //check the user type of the user
                switch( \Auth::user()->user_type ){
                    case 'applicant':

                    break;
                    case 'teacher':
                        return redirect( 'teacher/dashboard' );
                    break;
                    case 'student':
                        return redirect( 'student/dashboard' );
                    break;
                    case 'superadmin':
                        break;
                    case 'admin':
                        return redirect( 'admin/dashboard' );
                    break;
                    default:
                        $error = 'User type not found';
                    break;
                }

            }else{
                $error = trans( 'general.username_password_incorrect');
            }

        }

        $this->setLayout( 'gntl');
        Html::loadToastr();

        return view( 'layouts.'.$this->theme.'_login' )
            ->with( 'error' , $error )
            ->render();
    }

    public function logout( )
    {
        \Auth::logout();
        // do some garbage cleaning here
        redirect( 'login' )->send();
    }

    public function studentLandingPage( Request $r )
    {

        if( $r->isMethod('post') ){

            $s = new StudentEntity();
            $r->request->add(['user_type' => 'student']);

            if( ! $student = $s->store( $r ) ){
             return [
                 'success' => false,
                 'message' => $s->displayErrors()
             ];
            }

            // send confirmation email
             $this->sendConfirmationEmail( $student );

            return redirect( 'student/application/success' );
        }

        $content    = view( 'front.student_landing' )
            ->with( 'r' , $r );

        return $this->layout
            ->with( 'content' , $content )
            ->render();
    }

    /**
     *
     */
    public function studentConfirm( Request $r )
    {
        $uid = Text::recoverInt( $r->uid );
        $user = UserEntity::find( $uid );

        if( ! $user ){

        }

        if( $user->confirmed == 1 ){
            \Session::flash( 'message' , trans('general.already confirmed') );
            return redirect( 'login' );
        }

        if( $user->confirmation_code == $r->c ) {
            // set confirmation flag
            $user->confirmed = 1;
            $user->save();

            // autologin the user if successful
            \Auth::loginUsingId( $user->id );

            return redirect( 'student/dashboard' );
        }else{
            $this->layout->content = view( 'front.error' )->with( 'error' , trans( 'general.invalid_confirmation_code') );
            return $this->layout;
        }

    }

    public function studentSuccess()
    {
        return [];
    }

    public function apply( Request $r )
    {
        $errors = null;

        // check if user submited a form
        if( $r->isMethod(  'post' )){

            $applicant = new Applicants();

            if( ! $applicant->store( $r ) ){
                $errors = $applicant->getErrors();
            }
        }

        $countries  = Countries::selectList( ['default' => $r->country_id] );

        $content    = view( 'front.applicant_landing' )
            ->with( 'country_select' , $countries )
            ->with( 'r' , $r )
            ->with( 'errors', $errors )
            ->render();

        Html::instance()->addScript( '/public/app/js/front/teacher_signup.js' );
        Html::instance()->addScript( '/public/plugins/validation/jqBootstrapValidation.js' );
        Html::loadDateCombo();

        return $this->layout->with( 'content' , $content )
            ->render();
    }

    public function applicationSuccess()
    {
        $content =  view( 'front.application_success' );
        return $this->layout->with( 'content' , $content )
            ->render();
    }

    private function sendConfirmationEmail( UserEntity $user )
    {
        view()->addLocation( __DIR__.'/../Views/emails' );

        // check first if email is valid
        \Mail::send('confirm_account', ['user' => $user],
            function ($m) use ($user) {
                $m->from( env( 'APP_EMAIL_SENDER' ), trans('general.confirm_account') );
                $m->to( $user->email, $user->displayName() )
                ->subject( trans( 'general.confirmation_subject' ) );
        });
    }
}
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
use App\Models\Users\User;
use Helpers\Html;
use Illuminate\Http\Request;

class FrontController extends Controller{

    private $theme;
    private $theme_path;
    private $layout_path;

    public function __construct()
    {
        $this->theme = env( 'APP_THEME');
        $this->theme_path = __DIR__.'/../Views/themes/'.env( 'APP_THEME' ).'/';
        $this->layout_path = __DIR__.'/../Views/layouts/'.env( 'APP_THEME' ).'/';
        $this->front_layout_path = __DIR__.'/../Views/layouts/'.env( 'FRONT_THEME' ).'/';
        $this->front_theme_path = __DIR__.'/../Views/themes/'.env( 'FRONT_THEME' ).'/';

        view()->addLocation( $this->layout_path );
        view()->addLocation( $this->theme_path );
        view()->addLocation( $this->front_theme_path );
        view()->addLocation( $this->front_layout_path );
    }

    public function login( Request $r )
    {
        $error = null;
        if( $r->isMethod( 'post' ) ){

            if( $user = \Auth::attempt( array( 'username' => $r->username, 'password' => $r->pwd  )  ) ){

                // log the login details
                //Logins::log( \Auth::user()->id );

                //check the user type of the user
                switch( \Auth::user()->user_type ){
                    case 'applicant':

                        break;
                    case 'teacher':
                        break;
                    case 'student':
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

            }

        }

        return view( $this->theme.'_login' )
            ->with( 'errors' , $error )
            ->render();
    }

    public function studentLandingPage( Request $r )
    {
        $content    = view( 'front.student_landing' )->with( 'r' , $r );
        return view( env( 'FRONT_THEME').'_empty' )
            ->with( 'content' , $content )
            ->render();
    }

    public function applicantLandingPage( Request $r )
    {
        $errors = null;

        // check if user submited a form
        if( strtolower( $r->method() ) == 'post'){
            $applicant = new Applicant();
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

        return view( env( 'FRONT_THEME').'_empty' )
        ->with( 'content' , $content )
        ->render();
    }


}
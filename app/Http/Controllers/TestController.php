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
use Illuminate\Http\Request;

class TestController extends Controller{

    public function __construct()
    {
        // frontend theme is called agency
        parent::__construct();
    }

    public function testMail()
    {
        view()->addLocation( __DIR__.'/../Views/emails' );
        // check first if email is valid
        $user = UserEntity::find( 16 );

        $m = \Mail::send( 'confirm_account', ['user' => $user],
            function( $m ) use ($user) {
                $m->from( 'dennis@cerveo.com',  'Confirmation email test' );
                $m->to( 'dennisagulo@gmail.com',  'Ana Riza' )
                    ->subject( 'Test Mailgun' );
            }
        );

        dd( $m );
        exit;
    }
}
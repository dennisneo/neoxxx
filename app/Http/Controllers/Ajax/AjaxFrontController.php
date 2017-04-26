<?php

namespace App\Http\Controllers\Ajax;


use App\Models\Settings\Settings;
use App\Models\Users\Admins;
use App\Models\Users\Applicants;
use App\Models\Users\StudentEntity;
use App\Models\Users\UserEntity;
use Helpers\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AjaxFrontController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function saveApplication( Request $r )
    {
        $r->request->add( [ 'user_type' => 'applicant' ] );
        $applicant = new Applicants();
        if( $a = $applicant->store( $r ) ){
            // send email to admins for new accounts
            $admins = ( new Admins )->getAll();

            foreach( $admins as $admin ){
                $this->notifyAdminNewApplicant( $applicant , $admin );
            }

        }else{
            return [
                'success' => false,
                'message' => $applicant->getErrors()
            ];
        }

        // do notify admins here
        //$e = collect( str_split( $a->password))->every( 5 );
        $e = '';
        return [
            'success' => true,
            'uid' => Text::convertInt( $a->id ),
            'e' => $e
        ];
    }

    /**
     * New student registering
     *
     * @param Request $r
     * @return array
     */
    public function saveNewStudent( Request $r )
    {

        $r->request->add(['user_type' => 'student']);

        $student = new StudentEntity();
        // validate captcha
        $recaptcha_response = \Request::get('g-recaptcha-response');

        if( ! $r->is_validated ){
            $recaptcha_validate = $this->validateRecaptcha( $recaptcha_response );
            if( ! $recaptcha_validate->success ){
                return [
                    'success' => false,
                    'message' => 'Recaptcha validation failed',
                    'recaptcha_validation' => 'fail'
                ];
            }
        }

        \DB::beginTransaction();
        try{
            if( ! $student->store( $r ) ){
                return [
                    'success' => false,
                    'message' => $student->displayErrors()
                ];
            }

            $free_credits = Settings::getByKey( 'credits_free', 0 );

            // add student some FREE credits
            $student->addCredits( $free_credits );
            $student->ccid = Text::convertInt( $student->id );

            // send email to student
            // we can use events later for this
            $this->sendEmailToNewStudent( $student );

        }catch ( \Exception $e ){
            \DB::rollBack();
            return [
                'success' => false,
                'student' => $e->getMessage()
            ];
        }

        \DB::commit();

        return [
            'success' => true,
            'student' => $student
        ];
    }

    private function sendEmailToNewStudent( $student )
    {

        view()->addLocation( app_path().'/Http/Views/');
        $params = unserialize( $student->params );

        if( ! Mail::send('emails.new_student', ['student' => $student , 'params' => $params ], function ($m) use ( $student ) {
            $m->from( 'accounts@nativeenglishonline.com' , env('COMPANY_NAME'));
            $m->to( $student->email, $student->first_name.' '.$student->last_name )
                ->subject( 'Welcome to '.env('COMPANY_NAME') );
        }) ){
            throw new \Exception(' Email sending failed ');
        }

    }

    private function validateRecaptcha( $recaptcha_response )
    {
        // set post fields
        $post = [
            'secret'     => env( 'RECAPTCHA_SECRET'),
            'response'   => $recaptcha_response,
            'remoteip'   => $_SERVER['REMOTE_ADDR'],
        ];

        $ch = curl_init( 'https://www.google.com/recaptcha/api/siteverify' );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        // execute!
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close( $ch );
        $response = json_decode($response);

        return $response;
    }

    private function notifyAdminNewApplicant( UserEntity $user , UserEntity $admin )
    {
        view()->addLocation( __DIR__.'/../../Views/emails' );

        // check first if email is valid
        \Mail::send( 'new_applicant', [ 'user' => $user ],
            function ($m) use ($user , $admin) {
                $m->from( env( 'APP_EMAIL_SENDER' ),  'System Message' );
                $m->to( $admin->email , $admin->displayName() )
                    ->subject( 'New Applicant' );
            });
    }

}

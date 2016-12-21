<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Ajax;


use App\Models\Settings\Settings;
use App\Models\Users\Applicants;
use App\Models\Users\StudentEntity;
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
        if( ! $a = $applicant->store( $r ) ){
            return [
                'success' => false,
                'message' => $applicant->getErrors()
            ];
        }

        // do notify admins here
        $e = collect( str_split( $a->password))->every( 5 );
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

}

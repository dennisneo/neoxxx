<?php

namespace App\Http\Controllers;

use App\Http\Models\Locations\Countries;
use App\Models\ClassSessions\ClassSessions;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Placement\QuestionChoices;
use App\Models\Placement\Questions;
use App\Models\Users\Applicant;
use App\Models\Users\User;
use App\Models\Users\UserEntity;
use Faker\Factory;
use Helpers\Alipay;
use Helpers\Html;
use Illuminate\Http\Request;

class UtilsController extends Controller{

    public function __construct()
    {

    }

    public function timeoffset()
    {
        $timezone = "Asia/Seoul";

        $dateTimeZoneManila = new \DateTimeZone( "Asia/Singapore");
        $dateTimeZoneUser = new \DateTimeZone( $timezone );

        //dd( $dateTimeZoneUser );
        $dateTimeManila = new \DateTime("now", $dateTimeZoneManila );
        $dateTimeUser = new \DateTime("now", $dateTimeZoneUser );
        $offset = $dateTimeManila->getOffset() - $dateTimeUser->getOffset();

        return $offset;
    }

    public function viewEmailTemplate( $email_view )
    {
        view()->addLocation( app_path().'/Http/Views/');
        switch( $email_view ){
            case 'new_student':
                $student = UserEntity::where( 'username' , 'student@neo.com')->first();
                $params = unserialize( $student->params );
                return view('emails.new_student' , [ 'student' => $student, 'params' => $params ]);
            break;
        }
    }

    public function alipay()
    {
        if( env('ALIPAY_LIVE') ){
            echo 'OKK';
        }else{
            echo 'FALSE';
        }
        dd( 'test' );
        /**
        $pay         = new Alipay();
        $payment_url = $pay->createPayment( 'Native English Online', 25 , 'USD', 'NEO Payment' );

         return $payment_url;
        ***/

        $partner = "2088101122136241";//fill with the partnerID which we already offered you (required fields)
        $security_code = "760bdzec6y9goq7ctyx96ezkz78287de";//fill with the security key which we already offered you (required fields)
        $_input_charset = "utf-8";
        $sign_type = "MD5";
        $transport= "http";
        $notify_url = env('ALIPAY_NOTIFY_URL');//first you should change this url. if you want to know the function of the notify_url, you should read the alipay overseas order receiving interface file which we already offered you
        $return_url = env('ALIPAY_RETURN_URL');

        $parameter = array(
            "service" => "create_forex_trade", //this is the service name
            "partner" =>$partner,
            "return_url" =>$return_url,
            "notify_url" =>$notify_url,
            "_input_charset" => $_input_charset,
            "subject" => "NEO English Learning", //subject is the name of the product, you'd better change it
            "body" =>"Test 1234",  //body is the description of the product , you'd beeter change it
            "out_trade_no" => time() ,
            "total_fee" => "10", //the price of products
            "currency"=>"USD", // change it as the currency which you used on your website
        );

        $alipay = new Alipay\AlipayService( $parameter,$security_code,$sign_type);

        $link   =   $alipay->create_url();
        echo "<br/> <a href= $link  target= \"_blank\">submit</a>";

    }

    public function pwd( Request $r )
    {
        /**
        $user  = UserEntity::find( 20 );
        $params = unserialize( $user->params );
        $pwd  = $user->getPassword( $params['pwd']);
         **/
        $pwd = 'arfarf';
        dd( \Hash::make( $pwd ) );
    }

    public function populateQuestions()
    {
        $lg_array = LearningGoals::all()->pluck('goal_id')->toArray() ;

        for( $i = 0 ; $i < 20 ; $i++ ){

            $faker =  Factory::create();
            $key = array_rand ( $lg_array , 1  );

            $q = new Questions;
            $q->question = $faker->paragraph;
            $q->cat_id   = $lg_array[ $key ] ;
            $q->added_at  = date('Y-m-d H:i:s');
            $q->save();

            $key = array_rand ( [0,1,2,3] , 1  );

            for( $n = 0 ; $n <  4 ; $n++ ){
                $c = new QuestionChoices();
                $c->choice = $faker->sentence;
                $c->q_id = $q->q_id;
                $c->is_answer = $n == $key ? 1 : 0;
                $c->added_at = date( 'Y-m-d H:i:s');
                $c->save();
            }

        }

        return 'OKKK';
    }

    public function teacherSched()
    {
        $start = '2016-12-20 08:00:00';
        $end = '2016-12-20 08:39:00';
        $teacher_id = 40;
        echo ( new ClassSessions)->hasConflict( $start, $end , $teacher_id );
        exit;
    }
}
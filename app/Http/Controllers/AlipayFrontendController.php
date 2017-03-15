<?php

namespace App\Http\Controllers;

use App\Http\Models\Locations\Countries;
use App\Models\Financials\CreditCost;
use App\Models\Financials\PaymentKeys;
use App\Models\Financials\Payments;
use App\Models\Notices\AlipayNotices;
use App\Models\Users\Applicant;
use App\Models\Users\Applicants;
use App\Models\Users\StudentEntity;
use App\Models\Users\Students\StudentCredits;
use App\Models\Users\User;
use App\Models\Users\UserEntity;
use Helpers\Html;
use Helpers\Text;
use Illuminate\Http\Request;

class AlipayFrontendController extends Controller{

    public function __construct()
    {

    }

    public function notify( $cost_id , $user_id, $skey , Request $r  )
    {
        // check if skey is found
        // prevent duplicate entry
        if( ! $key = PaymentKeys::check( $user_id , $skey ) ){
              // do not add payment
             // return;
        }

        $user_id = Text::recoverInt( $user_id );
        $notice  = json_encode( $r->all() );

        $credit_cost = CreditCost::find( $cost_id );

        $n = new AlipayNotices();
        $n->added_at = date('Y-m-d H:i:s');
        $n->notice = $notice;
        try {
            $n->save();
        }catch( \Exception $e ){
            \Log::error( $e->getMessage() );
        }

        $r->request->add( [ 'cost_id' => $cost_id , 'credits' => $credit_cost->credits ] );
        $r->merge([ 'user_id'=> $user_id]);

        // add credit to user id
        try{
            StudentCredits::getCreditsByStudentId( $user_id , true )->add( $r );
        }catch ( \Exception $e ){
            \Log::error( $e->getMessage() );
        }


        //$key->delete();

    }

    public function ret( $cost_id , Request $r )
    {
        return redirect( 'student/credits/success/'.$cost_id );
    }
}
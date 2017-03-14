<?php

namespace App\Http\Controllers;

use App\Http\Models\Locations\Countries;
use App\Models\Financials\CreditCost;
use App\Models\Financials\Payments;
use App\Models\Notices\AlipayNotices;
use App\Models\Users\Applicant;
use App\Models\Users\Applicants;
use App\Models\Users\StudentEntity;
use App\Models\Users\User;
use App\Models\Users\UserEntity;
use Helpers\Html;
use Helpers\Text;
use Illuminate\Http\Request;

class AlipayFrontendController extends Controller{

    public function __construct()
    {

    }

    public function notify( $cost_id , Request $r  )
    {
        $notice  = json_encode( $r->all());

        $n = new AlipayNotices();
        $n->added_at = date('Y-m-d H:i:s');
        $n->notice = $notice;
        $n->save();

        $r->request->add(['cost_id' => $cost_id ]);
        $payment= new Payments();
        $payment->store( $r );

        redirect( 'student/credits/success/'.$cost_id );
    }

    public function ret( Request $r )
    {
        /**
        $notice  = json_encode( $r->all() );

        $n = new AlipayNotices();
        $n->added_at = date('Y-m-d H:i:s');
        $n->notice = $notice;
        $n->save();
        **/
        return 'Landing page after alipay payment';
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Models\Locations\Countries;
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


    public function notify()
    {
        $notice  = print_r( $_REQUEST , true );

        $n = new AlipayNotices();
        $n->added_at = date('Y-m-d H:i:s');
        $n->notice = $notice;
        $n->save();

        $n->added_at = date('Y-m-d H:i:s');
        return 'notify test';
    }

    public function ret()
    {
        return 'Landing page after alipay payment';
    }
}
<?php

namespace App\Http\Controllers\Admin;


use App\Models\Users\StudentEntity;
use App\Models\Users\UserEntity;
use Helpers\Html;
use Illuminate\Http\Request;

class AdminController extends AdminBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function dashboard()
    {
        $this->layout->content = view('admin.dashboard.dashboard');
        Html::loadChart();
        Html::instance()->addScript( 'public/app/admin/dashboard/dashboard.js' );
        Html::instance()->addScript( 'public/app/admin/dashboard/dashboard_chart.js' );
        return $this->layout;
    }

    public function profile( Request $r )
    {
        $this->layout->content  =  view('admin.dashboard.admin_profile' , [ 'me' => UserEntity::me() ] );
        Html::instance()->addScript( 'public/app/admin/admin_profile.js' );
        Html::loadDateCombo();
        Html::loadFileupload();
        return $this->layout;
    }
}
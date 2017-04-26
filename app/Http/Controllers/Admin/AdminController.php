<?php

namespace App\Http\Controllers\Admin;


use Helpers\Html;

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

}
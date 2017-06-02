<?php

namespace App\Http\Controllers\Admin;


use Helpers\Html;
use Illuminate\Http\Request;

class AdminFinancialsController extends AdminBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function payment_history()
    {
        Html::loadDatepicker();
        Html::instance()->addScript( 'public/app/admin/financials/admin_payment_history.js' );
        $this->layout->content      =  view('admin.financials.admin_payment_history');
        return $this->layout;
    }

    public function salaries( Request $r )
    {
        $this->layout->content = view('admin.financials.admin_salary_history');
        $this->layout->vue_version = '2.1.9';
        Html::instance()->addScript( 'public/app/admin/financials/admin_salary_history.js' );
        Html::loadDatepicker();

        return $this->layout;
    }
}
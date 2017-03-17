<?php

namespace App\Http\Controllers\Admin;


use Helpers\Html;

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

}
<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\Financials\Payments;
use Illuminate\Http\Request;

class AjaxFinancialsController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function paymentHistory( Request $r )
    {
        $payments = new Payments;

        return [
            'success' => true,
            'payments' => $payments->getAll( $r ),
            'total_entries' => $payments->getTotal(),
            'sum' => $payments->getSum()
        ];
    }
}
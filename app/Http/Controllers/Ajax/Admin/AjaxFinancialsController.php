<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\Financials\Payments;
use App\Models\Salaries\SalaryDailyDetails;
use App\Models\Salaries\SalaryHistory;
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
            'payments' => $payments->getCollection( $r ),
            'total_entries' => $payments->getTotal(),
            'sum' => $payments->getSum()
        ];
    }

    public function getSalaries( Request $r )
    {
        $salaries = SalaryHistory::factory()->getCollection( $r );
        return [
            'success' =>true,
            'salaries' =>$salaries
        ];
    }
    
    public function getDailySalary( Request $r )
    {

        $sh = SalaryHistory::find( $r->history_id );
        $ds =  $sh->getDaily( $r );
        return [
            'success' =>true,
            'ds' => $ds
        ];

    }
}
<?php
namespace App\Http\Controllers\Ajax\Finance;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\Financials\Payments;
use App\Models\Salaries\SalaryHistory;
use Illuminate\Http\Request;
use Event;

class AjaxFinanceController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function getPayments( Request $r )
    {
        $payments = ( new Payments)->getAll( $r )->vuefyThisCollection();
        return [
            'success' =>true,
            'payments' => $payments
        ];
    }
    

}
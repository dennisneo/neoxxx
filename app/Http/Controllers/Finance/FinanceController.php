<?php

namespace App\Http\Controllers\Finance;

use App\Models\Users\StudentEntity;
use App\Models\Users\TeacherEntity;
use App\Models\Users\Teachers;
use App\Models\Users\UserEntity;
use Helpers\Html;
use Illuminate\Http\Request;

class FinanceController extends FinanceBaseController{

    public function __construct()
    {
        parent::__construct();
        $this->layout->background_color = '#5A96DB';
    }

    public function payments( Request $r )
    {
        Html::loadDatepicker();
        Html::loadToastr();
        Html::instance()->addScript( '/public/app/finance/finance_dashboard.js' );
        $this->layout->content = view( 'finance.finance_payments' , [ 'r' => $r ] );
        return $this->layout;
    }

    public function salary( Request $r )
    {
        $this->layout->content = view( 'finance.finance_salary' , [ 'r' => $r ] );
        return $this->layout;
    }

}
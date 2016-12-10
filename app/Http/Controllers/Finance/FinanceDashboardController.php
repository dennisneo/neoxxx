<?php

namespace App\Http\Controllers\Finance;

use App\Models\Users\StudentEntity;
use App\Models\Users\TeacherEntity;
use App\Models\Users\Teachers;
use App\Models\Users\UserEntity;
use Helpers\Html;
use Illuminate\Http\Request;

class FinanceDashboardController extends FinanceBaseController{

    public function __construct()
    {
        parent::__construct();
        $this->layout->background_color = '#5A96DB';
    }

    public function index( Request $r )
    {
        $this->indexAssets();
        $this->layout->content = view( 'finance.finance_dashboard' , [ 'r' => $r ] );
        return $this->layout;
    }

    private function indexAssets()
    {

    }

}
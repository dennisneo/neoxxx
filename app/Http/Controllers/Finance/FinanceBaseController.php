<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Users\UserEntity;
use Helpers\Html;

class FinanceBaseController extends Controller{

    public function __construct()
    {
        parent::__construct();
        // check user if finance
        $this->loadDefaultAssets();
    }

    private function loadDefaultAssets()
    {
        Html::loadToastr();
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Teacher\TeacherBaseController;
use App\Models\Users\TeacherEntity;
use App\Models\Users\TeacherPivot;
use Helpers\Html;
use Illuminate\Http\Request;

class AdminSalaryController extends AdminBaseController{

    public function __construct()
    {
        parent::__construct();
        Html::loadToastr();
    }

    public function index()
    {

    }


}
<?php

namespace App\Http\Controllers\Teacher;

use Helpers\Html;

class TeacherDashboardController extends TeacherBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->layout->content = ' OKKK Content ';
        return $this->layout;
    }

}
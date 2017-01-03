<?php

namespace App\Http\Controllers\Partials;

use App\Http\Controllers\Controller;
use App\Models\Users\UserEntity;

class ModalsController extends Controller{

    public static function  studentInfoModal()
    {

        return view( 'partials.modals.student_info_modal' )->render();
    }
}
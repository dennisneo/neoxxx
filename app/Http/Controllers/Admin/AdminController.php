<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Admin;


use Helpers\Html;

class AdminController extends AdminBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function dashboard()
    {

        $this->layout->content = view('admin.dashboard.dashboard');
        Html::instance()->addScript( 'public/app/admin/dashboard/dashboard.js' );
        return $this->layout;

    }

}
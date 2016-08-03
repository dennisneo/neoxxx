<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Admin;


use Helpers\Html;

class AdminLearningGoalsController extends AdminBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->layout->content = view('admin.lg.lg_index');
        Html::instance()->addScript( 'public/app/admin/lg/lg.js' );
        Html::loadToastr();
        return $this->layout;
    }
    
}
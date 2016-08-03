<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Admin;


use Helpers\Html;

class AdminPlacementExamController extends AdminBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->layout->content = view('admin.pe.pe_index');
        Html::instance()->addScript( 'public/app/admin/pe/pe.js' );
        Html::loadToastr();
        return $this->layout;
    }

    public function question()
    {
        $this->layout->content = view('admin.pe.pe_question');
        Html::instance()->addScript( 'public/app/admin/pe/q.js' );
        //Html::
        Html::loadToastr();
        return $this->layout;
    }
    
}
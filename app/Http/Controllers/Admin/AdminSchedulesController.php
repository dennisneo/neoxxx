<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Admin;

use App\Models\Settings\Settings;
use App\Models\Users\Applicants;
use Helpers\Html;
use Illuminate\Http\Request;

class AdminSchedulesController extends AdminBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        Html::loadFileupload();
        Html::loadDatepicker();
        $this->layout->content      =  view('admin.schedules.admin_schedules');
        Html::instance()->addScript( 'public/app/admin/schedules/admin_schedules.js' );
        return $this->layout;
    }

}
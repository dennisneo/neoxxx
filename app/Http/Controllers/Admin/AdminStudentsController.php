<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Admin;

use App\Models\Users\Applicants;
use Helpers\Html;
use Illuminate\Http\Request;

class AdminStudentsController extends AdminBaseController{

    public function __construct()
    {
        parent::__construct();
        Html::loadToastr();
    }

    public function index()
    {
        $this->layout->content = view('admin.students.students_index');
        Html::instance()->addScript( 'public/app/admin/students/students.js' );
        return $this->layout;
    }

    public function teacher( $id , Request $r )
    {

    }


}
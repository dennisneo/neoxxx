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

class AdminApplicantsController extends AdminBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->layout->content = view('admin.appl.applicants_index');

        Html::instance()->addScript( 'public/app/admin/appl/appl_index.js' );
        Html::loadToastr();
        return $this->layout;
    }

    public function applicant( $id , Request $r )
    {
        $a = Applicants::find( $id );

        $this->layout->content = view('admin.appl.applicant')
            ->with( 'a' , $a );

        Html::instance()->addScript( 'public/app/admin/appl/applicant.js' );
        Html::loadToastr();

        return $this->layout;
    }



}
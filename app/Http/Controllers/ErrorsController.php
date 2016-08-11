<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers;

use App\Http\Models\Locations\Countries;
use App\Models\Users\Applicant;
use App\Models\Users\Applicants;
use App\Models\Users\StudentEntity;
use App\Models\Users\User;
use App\Models\Users\UserEntity;
use Helpers\Html;
use Helpers\Text;
use Illuminate\Http\Request;

class ErrorsController extends Controller{

    public function __construct()
    {
        // frontend theme is called agency
        parent::__construct( 'global' );
    }


}
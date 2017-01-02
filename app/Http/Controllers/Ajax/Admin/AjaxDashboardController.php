<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Placement\QuestionChoices;
use App\Models\Placement\Questions;
use App\Models\Users\Applicants;
use App\Models\Users\Students;
use App\Models\Users\UserEntity;
use App\Models\Utilities\Modifications;
use Helpers\Text;
use Illuminate\Http\Request;

class AjaxDashboardController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function latestApplicants( Request $r ){

        $r->request->add( [ 'limit' => 5 ] );

        $app = new Applicants;
        $applicants = $app->getAllApplicants( $r );

        return [
            'success' =>true,
            'applicants' => $applicants

        ];
    }

    public function latestStudents( Request $r ){

        $r->request->add( [ 'limit' => 5 ] );

        $s = new Students;
        $students  = $s->getStudents( $r );
        $students = $s->vuefyAll( $students );

        return [
            'success'   => true,
            'students'  => $students
        ];

    }

    public function chartData(  Request $r )
    {
        $twelve_days_ago = date( 'Y-m-d H:i:s' , mktime( 0,0,0, date('m') , date('d')-12 , date('Y') ) );
        $dates = Students::where( 'created_at' , '>=' , $twelve_days_ago )
            //->select( ["TO_DAYS( 'created_at' ) as d "," count() as cnt" ] )
            ->select( \DB::raw( " TO_DAYS( created_at ) as d , count( id ) as cnt , DATE( created_at ) as date, DAY( created_at ) as day " ) )
            ->where( 'user_type' , 'student' )
            ->groupBy( 'd' )
            ->get();

        $d_arr = [];
        foreach( $dates as $d ){
            //$d_arr[ $d->day ] = $d;
        }
        return [
            'success' =>true,
            'dates' => $dates
        ];
    }
}
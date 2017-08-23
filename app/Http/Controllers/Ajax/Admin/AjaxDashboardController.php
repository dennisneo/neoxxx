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

    /**
     * @param Request $r
     * @return array
     */
    public function profile( Request $r )
    {
        $me = UserEntity::me();

        return [
            'success' =>true,
            'me' => $me
        ];
    }

    /**
     * @param Request $r
     */
    public function saveProfile( Request $r )
    {
        $me = UserEntity::me();
        if ( ! $me->store( $r ) ){
            return [
                'success' =>false,
                'message' => $me->displayErrors()
            ];
        }

        return [
            'success' => true ,
            'me' => $me
        ];
    }

    public function changePassword( Request $r )
    {
        $me = UserEntity::me();

        if( ! $r->new_pass ){
            return [
                'success' => false,
                'message' => 'New password must not be empty'
            ];
        }

        if( $r->new_pass != $r->confirm_pass ){
            return [
                'success' => false,
                'message' => 'Password mismatch'
            ];
        }

        $cp = \Hash::make( $r->current_pass );
        if( ! \Hash::check( $r->current_pass  , $me->password  ) ){
            return [
                'success' => false,
                'message' => 'Invalid current password',
            ];
        }

        $me->password = \Hash::make( $r->new_pass );
        $me->save();

        return [
            'success' => true ,
            'me' => $me
        ];

    }

    public function uploadProfilePhoto( Request $r )
    {
        if( $r->hasFile('photo') ){
            /**
             * checks if file was uploaded successfully
             */
            if (! $r->file('photo')->isValid()) {
                return [
                    'success' =>   false,
                    'message' =>   'File not valid'
                ];
            }

            $user = UserEntity::me();

            if( ! $user->uploadProfilePhoto( $r ) ){
                return [
                    'success' => false,
                    'message' => $user->displayErrors()
                ];
            }

            return [
                'success' =>true,
                'profile' => $user->vuefy()
            ];
        }

        return [
            'success' => false,
            'message' => 'Uploaded file not found'
        ];

    }

    /**
     * @param Request $r
     * @return array
     */
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
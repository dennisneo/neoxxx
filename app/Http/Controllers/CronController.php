<?php

namespace App\Http\Controllers;


use App\Models\ClassSessions\ClassSessions;
use App\Models\Financials\SalaryDetails;
use App\Models\Settings\Settings;
use Illuminate\Http\Request;

class CronController extends Controller{

    public function __construct()
    {

    }

    /**
     * Do the computation on a Monday morning
     */
    public function computeSalary( Request $r )
    {
        // salary are computed from Monday to Sunday

        // check if its Monday past 12:00 am and less 6:00 am
        $prev_monday = strtotime( "previous monday" );
        $last_monday = date('Y-m-d H:i:s' , $prev_monday );
        $prev_sunday = $prev_monday + (7*24*60*60)-1;
        $last_sunday = date('Y-m-d 23:59:59' , $prev_sunday );

        $cs = ( new ClassSessions );
        $s = $cs->teacherWeekSalary(  $last_monday , $last_sunday );

        $rates = [
            'local' => Settings::getByKey( 'rate_local' ),
            'native' => Settings::getByKey( 'rate_native' ),
            'filipino' => Settings::getByKey( 'rate_filipino' ),
        ];


        foreach( $s as $v ){
            // save to salary details table
            $rate = isset( $rates[ $v->type ] ) ? $rates[ $v->type ] : 0;
            $income = ($rate / 60 ) *  $v->total_duration;
            $data = [ 'week_from' => $last_monday, 'week_to'=>$last_sunday,
                'teacher_id'    => $v->teacher_id,
                'total_minutes' => $v->total_duration,
                'rate' => $rate,
                'total_income' => $income,
                'deductions' => 0 ,
                'status'=> '',
                'notes'=> ''
            ];

            if( ! $r = ( new SalaryDetails )->store( $data ) ){

            }

        }

    }

}
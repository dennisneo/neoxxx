<?php

namespace App\Models\Users;

use App\Models\BaseModel;
use App\Models\ClassSessions\ClassSessions;
use App\Models\Salaries\SalaryDailyDetails;
use App\Models\Salaries\SalaryHistory;
use Illuminate\Http\Request;

class TeacherPivot extends BaseModel{

    public $table       = 'teachers';
    public $primaryKey  = 'map_id';

    public $timestamps = false;

    protected  $fillable = [ 'rating', 'about', 'voice_url', 'type' ];

    public function getCollection( Request $r )
    {
        $this->setLpo( $r );
        $this->fields = [ 'a.*' ];

        $this->query = static::from( $this->table.' as a' );
        // insert conditions here

        $this->total = $this->query->count();

        $this->assignLpo();
        return $this->vuefyThisCollection();
    }

    public static function getByTeacherId( $teacher_id , $create_new = true )
    {
         $teacher = static::where( 'user_id' , $teacher_id )
            ->first();

         if( ! $teacher ){
           // create new entry for teacher if none is found
            if( $create_new ){
                $t  = new static;
                $t->user_id = $teacher_id;
                $t->save();

                return $t;
            }
         }

         return $teacher;
    }

    public static function byUserId( $user_id )
    {
        return static::where( 'user_id' , $user_id )->first();
    }

    public function store( Request $r )
    {
        $validator = \Validator::make( $r->all() , [
            // validation rules here
        ] );

        if( $validator->fails() ){
            $this->errors = $validator->errors()->all();
            return false;
        }

        $this->fill( $r->all() );
        $pk = $this->primaryKey;

        if( $r->$pk  ){
            $this->exists = true;
        }else{

        }

        $this->save();

        return $this;
    }

    /**
 * Get all active teachers that are due for range salary
 *
 * @param $date
 * @return Array
 */
    public function getSalaryUnprocessedAsOf( $date )
    {
        return $this->where( 'last_salary_computation' , '<' , $date )
            ->from( 'teachers as t')
            ->where( 'u.is_active' , '!=' , '0' )
            ->join( 'users as u' , 'u.id' , '=' , 't.user_id' )
            ->limit( 200 )
            ->get( [ 't.*', 'u.first_name' , 'u.last_name' , 'u.id' ] );
    }

    /**
     * Get all active teachers that are due for day salary computation
     *
     * @param $date
     * @return Array
     */
    public function getDaySalaryUnprocessedAsOf( $date )
    {
        return $this->where( 'last_day_salary_computation' , '<' , $date )
            ->from( 'teachers as t')
            ->where( 'u.is_active' , '!=' , '0' )
            ->join( 'users as u' , 'u.id' , '=' , 't.user_id' )
            ->limit( 200 )
            ->get( [ 't.*', 'u.first_name' , 'u.last_name' , 'u.id' ] );
    }

    public function processTeacherSalary( $teacher_id , $start_date , $end_date )
    {
        // get the daily income from range
        $daily_salary = SalaryDailyDetails::where( 'teacher_id' , $teacher_id )
        ->whereBetween( 'salary_date' , $start_date , $end_date )
        ->get( );

        foreach( $daily_salary as $s ){

        }

    }

    /**
     * Process the day income of all teachers
     *
     * @param Request $r
     */
    public function processDayIncome( Request $r )
    {
        if( ! $day = $r->day ){
            $day = date('Y-m-d' , strtotime('yesterday') );
        }

        $teachers   =   $this->getDaySalaryUnprocessedAsOf( $day );

        foreach( $teachers as $teacher ){

            $classes = ClassSessions::factory()->teacherDaySalary( $teacher->user_id, $day );
            $total_duration = 0;

            foreach( $classes as $class ){
                $total_duration +=   $class->duration;
            }

            $day_income =  ( $teacher->rate_per_hr / 60 ) *  $total_duration;

            // save the teacher income for yesterday
            $data = [
                'salary_date'   => $day,
                'teacher_id'    => $teacher->user_id,
                'total_minutes' => $total_duration,
                'rate' => $teacher->rate_per_hr,
                'day_income' => $day_income
            ];

            SalaryDailyDetails::factory()->store( $data );
            $teacher->last_day_salary_computation = $day;
            $teacher->save();
        }

    }

    /**
     * @param Request $r
     */
    public function processRangeIncome( Request $r )
    {
        /**
        if( strtotime( $r->end_date.' 23:59:59' ) > time() ){
            $this->errors[] = 'End time must be more than the current date';
            return false;
        }
        **/

        $last_month_date  =  new \DateTime();
        $last_month_date->modify( "last day of previous month" );

        if(  date( 'd' )  == 16 ){
            $start_date  = date('Y-m-01');
            $end_date    = date('Y-m-15');
        //}elseif( date( 'd' ) == $last_month_date->format( 'd') ){
        }elseif( date( 'd' ) == 11 ){
            $start_date      =   $last_month_date->format("Y-m-16");
            $end_date        =   $last_month_date->format("Y-m-d");
        }else{
            return 'No salary computations for today';
        }

        $begin  = new \DateTime( $start_date );
        $end    = new \DateTime( $end_date );

        $interval = \DateInterval::createFromDateString( '1 day' );
        $period = new \DatePeriod( $begin, $interval, $end);

        $teachers = $this->getSalaryUnprocessedAsOf( $end_date );
        
        foreach( $teachers as $t ){
            $total_income = 0;
            $total_duration = 0;

            foreach ( $period as $dt ){
                $classes = ClassSessions::factory()->teacherDaySalary( $t->user_id, $dt->format('Y-m-d') );
                $day_duration = 0 ;
                foreach( $classes as $class ){
                    $day_duration +=   $class->duration;
                }
                $day_income     =  ( $t->rate_per_hr / 60 ) *  $total_duration;
                $total_income   += $day_income;
                $total_duration += $day_duration;
            }

            $sal_data = [
                'day_from'      => $r->start_date,
                'day_to'        => $r->end_date,
                'teacher_id'    => $t->teacher_id,
                'total_minutes' => $total_duration,
                'ave_rate'      => 0,
                'total_income'  => $total_income,
                'deductions'    => 0,
                'prepared_at'   => date('Y-m-d H:i:s'),
                'status'        => 'on process',
                'notes'         => ' '
            ];

            SalaryHistory::factory()->store( $sal_data );

            $t->last_salary_computation = date( 'Y-m-d H:i:s');
            $t->save();
        }

        return null;

    }

    public function processDailyIncome()
    {
        $rate = $this->rate_per_hr;
        $teacher_id = $this->id;

        //$d = 30;

        switch( date( 'd' ) ){
        //switch( $d ){
            case 15:
                // get the last day of the previous month
                $last_month_date  =  new \DateTime();
                $last_month_date->modify( "last day of previous month" );
                $last_day_last_month = $last_month_date->format("d");

                if( $last_day_last_month == 31 ){
                    $start_date     =  $last_month_date->format( 'Y-m-d' );
                }else{
                    $start_date     =  date( 'Y-m-01' );
                }

                // end date is yesterday
                $end_date     =  date( 'Y-m-14' );

                $begin  = new \DateTime( $start_date );
                $end    = new \DateTime( $end_date );

                $interval = \DateInterval::createFromDateString('1 day');
                $period = new \DatePeriod($begin, $interval, $end);

                foreach ( $period as $dt ){
                    $classes[] = ClassSessions::factory()->teacherDaySalary( $teacher_id, $dt->format('Y-m-d') );
                    $total_duration = 0;
                    foreach( $classes as $class ){
                        $total_duration +=   $class->duration;
                    }
                    $day_income =  ( $rate / 60 ) *  $total_duration;
                }

                break;
            case 30:
                $start_date   =  date( 'Y-m-15' );
                $end_date     =  date( 'Y-m-30' );

                $begin  = new \DateTime( $start_date );
                $end    = new \DateTime( $end_date );

                $interval   = \DateInterval::createFromDateString('1 day');
                $period     = new \DatePeriod( $begin, $interval, $end );


                $total_income = 0;
                $total_duration = 0;

                foreach ( $period as $dt ){
                    $p = $dt->format('Y-m-d');
                    $classes = ClassSessions::factory()->teacherDaySalary( $this->id, $p );

                    $total_day_duration = 0;

                    foreach( $classes as $class ){
                        $total_day_duration +=   $class->duration;
                        $total_duration +=   $class->duration;
                    }
                    $day_income =  ( $rate / 60 ) *  $total_day_duration;
                    $total_income += $day_income;
                    // save the result to salary daily details
                    $data = [
                        'salary_date'   => $p,
                        'teacher_id'    => $teacher_id,
                        'total_minutes' => $total_day_duration,
                        'rate' => $rate,
                        'day_income' => $day_income
                    ];
                    SalaryDailyDetails::factory()->store( $data );
                }

                $sal_data = [
                    'day_from' => $start_date,
                    'day_to' => $end_date,
                    'teacher_id' => $teacher_id,
                    'total_minutes' => $total_duration,
                    'ave_rate' => 0,
                    'total_income' => $total_income,
                    'deductions' => 0,
                    'prepared_at' => date('Y-m-d H:i:s'),
                    'status' => 'on process',
                    'notes' => ' '
                ];

                SalaryHistory::factory()->store( $sal_data );

                $this->last_salary_computation = date( 'Y-m-d H:i:s');
                $this->save();

                break;
            default:
            break;
        }

    }



}
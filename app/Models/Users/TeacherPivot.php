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
     * @param $date
     * @return Array
     */
    public function getSalaryUnprocessedAsOf( $date )
    {
        return $this->where( 'last_salary_computation' , '<' , $date )
            ->from( 'teachers as t')
            ->where( 'u.is_active' , '!=' , '0' )
            ->join( 'users as u' , 'u.id' , '=' , 't.user_id' )
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

    public function processDailyIncome()
    {

        $rate = $this->rate_per_hr;
        $d = 30;
        $teacher_id = $this->id;

        //switch( date( 'd' ) ){
        switch( $d ){
            case 15:
                // get the last day of the previous month
                $last_month_date    =  new \DateTime();
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
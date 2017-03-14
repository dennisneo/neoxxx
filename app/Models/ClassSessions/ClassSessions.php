<?php

namespace App\Models\ClassSessions;

use Helpers\Text;
use Illuminate\Http\Request;

class ClassSessions extends ClassSessionEntity{

    protected $user_time_offset = 0;

    public function hasConflict( $start, $end , $teacher_id)
    {
        $count = static::where( 'teacher_id' , $teacher_id )
            ->whereBetween( 'schedule_start_at' , [ $start , $end ] )
            ->orWhereBetween( 'schedule_end_at' , [ $start , $end ] )
            ->whereIn( 'class_status' , ['active' , 'for confirmation' ])
            ->count();

        return $count;
    }


    public function teacherWeekSalary( $start , $end )
    {
        $cs =  ClassSessions::where( 'class_status' , 'done' )
            ->whereBetween( 'schedule_start_at', [ $start , $end ] )
            ->where( 't.last_salary_computation' , '<', $end  )
            ->from( 'class_sessions as cs' )
            ->join( 'teachers as t' , 't.user_id' , '=', 'cs.teacher_id' )
            ->join( 'users as u' , 'u.id' ,  '=', 'cs.teacher_id' )
            ->groupBy( 'teacher_id' )
            ->get( [ 'cs.*', 'u.first_name' , 'u.last_name', 't.type'  , \DB::raw( 'SUM( duration ) as total_duration' )  ] );


        return $cs;
    }

    public static function computeIncome( $minutes , $rate )
    {

    }

    /**
     * @param $cid
     * @return static collection
     */

    public function getClassSession( $cid )
    {
        $cs =  ClassSessions::where( 'class_id' , $cid )
            ->from( 'class_sessions as cs' )
            ->leftjoin( 'users as t', 't.id', '=' , 'cs.teacher_id' )
            ->join( 'users as s', 's.id', '=' , 'cs.student_id' )
            ->first( [ 'cs.*' ,  's.first_name as s_fname' , 's.last_name as s_lname' , 's.id as sid',
                't.first_name as t_fname' , 't.last_name as t_lname' , 't.id as tid' ] );

        if( ! $cs ){
            $this->errors[] =  trans( 'general.invalid_class_session');
            return false;
        }

        return $cs;
    }

    public function byStudentId( $student_id , Request $r )
    {
        $limit = $r->limit ? $r->limit : 20;

        $cs =  ClassSessions::where( 'student_id' , $student_id )
            ->from( 'class_sessions as cs' )
            ->leftjoin( 'users as t', 't.id', '=' , 'cs.teacher_id' );

        if( $r->incoming_only ){
            $now = date('Y-m-d H:i:s');
            $cs->where( 'schedule_start_at',  '>' , $now );
        }

        if( $r->class_status ){

            $class_status_arr = $r->class_status;

            if( is_string( $r->class_status )){
                $class_status_arr = explode(',' , $r->class_status);
            }

            $cs->whereIn( 'class_status',  $class_status_arr );
        }


        $this->total = $cs->count();

        $cs->orderBy( 'schedule_start_at', 'DESC' );
        $cs->limit( $limit );

        $schedules = $cs->get( [ 'cs.*' , 't.first_name as t_fname' , 't.last_name as t_lname' , 't.id as tid', ] );

        return $this->vuefyCollection( $schedules );

    }

    public function getAll( Request $r )
    {
        $this->limit = $r->limit ? $r->limit  : 20;
        $page = $r->page ? $r->page : 1;
        $offset = ( $page-1 ) * $this->limit;
        $order_by = $r->order_by ? $r->order_by : 'schedule_start_at';
        $order_direction = $r->order_direction ? $r->order_direction : 'DESC';

        $tid = Text::recoverInt( $r->tid );

        $fields = [ 'cs.*' ,  's.first_name as s_fname' , 's.last_name as s_lname' , 's.id as sid',
            't.first_name as t_fname' , 't.last_name as t_lname' , 't.id as tid' ];

        $cs =  ClassSessions::from( 'class_sessions as cs' );

        if( $r->tid ){
            $cs->where('teacher_id' , $r->tid );
        }

        if( $r->sid ){
            $cs->where('student_id' , $r->sid );
        }

        if( $r->q ){
            $cs->whereRaw(" MATCH( first_name, last_name ) against (? in boolean mode)", [$r->q] );
            $fields[] = \DB::raw(" MATCH( first_name, last_name ) against ( '$r->q' ) as score ");
        }

        if( $r->date_from && $r->date_to ){

            $date_from = date( 'Y-m-d' , strtotime( $r->date_from ) );
            $date_to = date( 'Y-m-d', strtotime( $r->date_to ) );

            $cs->where( 'schedule_start_at' , '>=' , $date_from );
            $cs->where( 'schedule_start_at' , '<=' , $date_to );

        }elseif( $r->date_from ){

        }

        $this->total = $cs->count();

        $cs->leftjoin( 'users as t', 't.id', '=' , 'cs.teacher_id' )
        ->leftjoin( 'users as s', 's.id', '=' , 'cs.student_id' );
        $cs->orderby( $order_by , $order_direction );
        $cs->limit( $this->limit )
            ->offset( $offset );

        $schedules = $cs->get( $fields );

        return $this->vuefyCollection( $schedules );
    }

    public function byTeacherId( Request $r )
    {
        $limit      = $r->limit ? $r->limit : 20;
        $page       = $r->page ? $r->page : 1;
        $offset     = ($page-1) * $limit;
        $order_by   = $r->order_by ? $r->order_by : 'schedule_start_at';
        $order_direction = $r->order_direction ? $r->order_direction :   'ASC';

        //$tid = Text::recoverInt( $r->tid );

        $tid = $r->tid;
        $fields = [ 'cs.*' , 's.first_name as s_fname' , 's.last_name as s_lname' , 's.id as sid' ];

        $cs =  ClassSessions::where( 'teacher_id' , $tid )
            ->from( 'class_sessions as cs' )
            ->leftjoin( 'users as s', 's.id', '=' , 'cs.student_id' );

        if( $r->q ){
            $cs->whereRaw(" MATCH( first_name, last_name ) against (? in boolean mode)", [$r->q] );
            $fields[] = \DB::raw(" MATCH( first_name, last_name ) against ( '$r->q' ) as score ");
        }

        if( $r->date_from && $r->date_to ){

            $date_from = date( 'Y-m-d' , strtotime( $r->date_from ) );
            $date_to = date( 'Y-m-d', strtotime( $r->date_to ) );

            $cs->where( 'schedule_start_at' , '>=' , $date_from );
            $cs->where( 'schedule_start_at' , '<=' , $date_to );

        }elseif( $r->date_from ){
            $date_from = date( 'Y-m-d' , strtotime( $r->date_from ) );
            $cs->where( 'schedule_start_at' , '>=' , $date_from );
        }

        $this->total = $cs->count();
        $cs->orderby( $order_by , $order_direction );
        $cs->limit( $limit );

        $this->sql = $cs->toSql();

        $schedules = $cs->get( $fields );

        return $this->vuefyCollection( $schedules );
    }

    public static function statusSelect( $default = 0)
    {

        $status =[
            'Active' => 'Active',
            'Done' => 'Done',
            'Absent' => 'Absent',
            'Cancelled' => 'Cancelled'
        ];

        return \Form::select( 'class_status' , $status ,  $default , [ 'class' => 'form-control' , 'id'=>'class_status' ] );
    }

    /**
    public function vuefy()
    {

        $timezone =  request()->user()->timezone ? request()->user()->timezone : 'Asia/Singapore';
        $time_offset = DateTimeHelper::timeOffsetFromAsiaManila( $timezone );
        //$adjusted_time  = strtotime( $this->schedule_start_at ) + $time_offset ;

        $adjusted_time = DateTimeHelper::serverTimeToTimezone( strtotime( $this->schedule_start_at ) , $timezone );

        $this->adjusted_start_at    = date( 'Y-m-d H:i:s' , $adjusted_time );
        $this->offset   = $time_offset;
        $this->teacher_short_name = $this->t_fname.' '.substr( $this->t_lname , 0 , 1 ).'.';
        $this->cid      = Text::convertInt( $this->class_id );
        $this->day      = date( 'M d, Y D' ,  DateTimeHelper::serverTimeToTimezone( strtotime( $this->schedule_start_at ) , $timezone ) );
        $this->time     = date( 'H:i:s a' ,  DateTimeHelper::serverTimeToTimezone( strtotime( $this->schedule_start_at ) , $timezone ) );

        return $this;
    }
    ***/

    public static function actualDurationSelect()
    {
        $duration = [ 0 => 'None' ];
        for( $i = 10 ; $i <= 60 ; $i = $i + 5 ){
            $duration[ $i ] = $i.' min';
        }

        return \Form::select( 'actual_duration' , $duration ,  '' , [ 'class' => 'form-control' , 'id'=>'actual_duration', 'style'=>'width:120px' ] );
    }

}
<?php

namespace App\Models\ClassSessions;

use App\Models\BaseModel;
use App\Models\Financials\Credits;
use App\Models\Users\UserEntity;
use Helpers\DateTimeHelper;
use Helpers\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

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
        $limit = $r->limit ? $r->limit : 10;

        $cs =  ClassSessions::where( 'student_id' , $student_id )
            ->from( 'class_sessions as cs' )
            ->leftjoin( 'users as t', 't.id', '=' , 'cs.teacher_id' );

        if( $r->incoming_only ){
            $now = date('Y-m-d H:i:s');
            $cs->where( 'schedule_start_at',  '>' , $now );
            $cs->limit( $limit );
        }

        $this->total = $cs->count();
        $cs->orderBy( 'schedule_start_at', 'DESC' );
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

        $tid = Text::recoverInt( $r->tid );
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

        }

        $this->total = $cs->count();
        $cs->orderby( $order_by , $order_direction );
        $cs->limit( $limit );

        $schedules = $cs->get( $fields );

        return $this->vuefyCollection( $schedules );
    }

    public static function statusSelect()
    {
        $status =[
            'active' => 'Active',
            'done' => 'Done',
            'absent' => 'Absent',
            'cancelled' => 'Cancelled'
        ];

        return \Form::select( 'class_status' , $status ,  '' , [ 'class' => 'form-control' , 'id'=>'class_status' ] );
    }


    public function vuefy()
    {

        $timezone =  request()->user()->timezone ? request()->user()->timezone : 'Asia/Singapore';
        $time_offset = DateTimeHelper::timeOffsetFromAsiaManila( $timezone );

        $adjusted_time  = strtotime( $this->schedule_start_at ) + $time_offset ;
        $this->adjusted_start_at    = date( 'Y-m-d H:i:s' , $adjusted_time );
        $this->offset = $time_offset;

        return $this;
    }

    public static function actualDurationSelect()
    {
        $duration = [ 0 => 'None' ];
        for( $i = 10 ; $i <= 60 ; $i = $i + 5 ){
            $duration[ $i ] = $i.' min';
        }

        return \Form::select( 'actual_duration' , $duration ,  '' , [ 'class' => 'form-control' , 'id'=>'actual_duration', 'style'=>'width:120px' ] );
    }

}
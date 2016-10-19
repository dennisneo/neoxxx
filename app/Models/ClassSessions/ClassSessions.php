<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\ClassSessions;

use App\Models\BaseModel;
use App\Models\Financials\Credits;
use App\Models\Users\UserEntity;
use Helpers\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class ClassSessions extends ClassSessionEntity{

    public function getClassSession( $cid )
    {

        $cs =  ClassSessions::where( 'class_id' , $cid )
            ->from( 'class_sessions as cs' )
            ->leftjoin( 'users as t', 't.id', '=' , 'cs.teacher_id' )
            ->join( 'users as s', 's.id', '=' , 'cs.student_id' )
            ->first( [ 'cs.*' ,  's.first_name as s_fname' , 's.last_name as s_lname' , 's.id as sid',
                't.first_name as t_fname' , 't.last_name as t_lname' , 't.id as tid', ] );

        if( ! $cs ){
            $this->errors[] =  trans( 'general.invalid_class_session');
            return false;
        }

        return $cs;
    }

    public function byStudentId( $student_id , Request $r )
    {
        $cs =  ClassSessions::where( 'student_id' , $student_id )
            ->from( 'class_sessions as cs' )
            ->leftjoin( 'users as t', 't.id', '=' , 'cs.teacher_id' );

        $this->total = $cs->count();
        $schedules = $cs->get( [ 'cs.*' , 't.first_name as t_fname' , 't.last_name as t_lname' , 't.id as tid', ] );

        return $this->vuefyCollection( $schedules );
    }

    public function byTeacherId( Request $r )
    {
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
        $schedules = $cs->get( $fields );

        return $this->vuefyCollection( $schedules );
    }

    public function vuefy()
    {
        $this->start_timestamp = strtotime($this->schedule_start_at);
        $this->end_timestamp = $this->start_timestamp + ( $this->duration*60 ) ;
        return $this;
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

    public static function durationSelect()
    {
        $duration = [ 0 => 'None' ];
        for( $i = 10 ; $i <= 60 ; $i = $i + 5 ){
            $duration[ $i ] = $i.' min';
        }

        return \Form::select( 'actual_duration' , $duration ,  '' , [ 'class' => 'form-control' , 'id'=>'actual_duration', 'style'=>'width:120px' ] );
    }

}
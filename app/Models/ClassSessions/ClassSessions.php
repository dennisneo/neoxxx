<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\ClassSessions;


use App\Models\Financials\Credits;
use App\Models\Users\UserEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class ClassSessions extends Model{

    protected $table        = 'class_sessions';
    protected $primaryKey   = 'class_id';
    public $timestamps = false;

    public $fillable    = [ 'class_id' , 'student_id', 'teacher_id' , 'duration' ];
    private $errors     =  [];

    public function store( Request $r )
    {
        $validator = Validator::make( $r->all(), [] );

        if( $validator->fails() ){
            $this->errors[] = '';
            return false;
        }

        $this->fill( $r->all() );
        $this->schedule_start_at =  date( 'Y-m-d H:i:s' , strtotime( $r->date.' '.$r->time ) );

        // check if session is in the future

        // get credits by duration
        $this->credits = Credits::getCreditsByDuration( $r->duration );

        if( $this->credits === false ){
            $this->errors[] = trans( 'invalid_credit_value' );
            return false;
        }

        // check if credit is not more than credit available
        $available_credit = Credits::getCreditsByStudentId( $this->student_id );

        if( $available_credit < $this->credits ){
            $this->errors[] = trans( 'insufficient_credits' );
            return false;
        }

        if( $r->class_id ) {
            $this->exists = true;
        }else{
            $this->set_at   =   date( 'Y-m-d H:i:s' );
            $this->set_by   =   UserEntity::me()->id;
        }

        if( ! $this->save() ){
            return false;
        }

        return $this;

    }

    public function vuefy()
    {

        $this->time = date( 'H:i a' , strtotime( $this->schedule_start_at ));
        $this->day = date( 'M d, Y' , strtotime( $this->schedule_start_at ));

        $this->teacher_short_name = ucwords( strtolower( $this->t_fname.' '.substr( $this->t_lname , 0 , 1 ).'.' ) );

        return $this;
    }

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


    public function getErrors()
    {
        $html = '<ul>';
        foreach( $this->errors as $e ){
            $html .= '<li>'.$e.'</li>';
        }
        $html .= '</ul>';

        return $html;
    }
}
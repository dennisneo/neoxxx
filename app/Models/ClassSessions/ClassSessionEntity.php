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

class ClassSessionEntity extends BaseModel{

    protected $table        = 'class_sessions';
    protected $primaryKey   = 'class_id';
    public $timestamps = false;

    public $fillable    = [ 'class_id' , 'student_id', 'teacher_id' , 'duration', 'class_status' , 'actual_duration',
        'comments' , 'class_performance' ];

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
        $twelve_hrs = time() + ( 60 * 60 * 12 );
        if( strtotime( $this->schedule_start_at ) < $twelve_hrs  ){
            $this->errors[] = trans( 'errors.later_than_twelve_hours' );
            return false;
        }

        // get credits by duration
        $this->credits = Credits::getCreditsByDuration( $r->duration );

        if( $this->credits === false ){
            $this->errors[] = trans( 'general.not_enough_credit' );
            $this->error_code = 'NOT_ENOUGH_CREDIT';
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

    /**
     * teachers updates a record each time they are done with a
     * class session
     */
    public function updateRecord( Request $r )
    {
        if( ! $this->canEdit() ){
            $this->errors[] = ' You do not have permission to modify this class '.$this->teacher_id.'=='.UserEntity::me()->id;
            return false;
        }
        if( ! $class = static::find( $r->class_id ) ){
            $this->errors[] = 'Class not found';
            return false;
        }

        $class->fill( $r->all() );
        $class->save();

        return $class;
    }

    public function vuefy()
    {
        $this->time = date( 'H:i a' , strtotime( $this->schedule_start_at ));
        $this->day = date( 'M d, Y' , strtotime( $this->schedule_start_at ));
        $this->class_status = ucwords( $this->class_status );
        $this->ccid = Text::convertInt( $this->class_id );
        // for teachers
        if( isset( $this->t_fname )){
            $this->teacher_short_name = ucwords( strtolower( $this->t_fname.' '.substr( $this->t_lname , 0 , 1 ).'.' ) );
        }

        // for students
        if( isset( $this->s_fname )) {
            $this->student_short_name = ucwords(strtolower($this->s_fname . ' ' . substr($this->s_lname, 0, 1) . '.'));
        }

        return $this;
    }

    public function uploadAudio( Request $r )
    {
        if( ! $this->class_id ){
            $this->errors[] = 'Can not upload file with no class associated with it';
            return false;
        }

        if( ! $this->teacher_id ){
            $this->errors[] = 'Can not upload file with no teacher associated with it';
            return false;
        }

        $valid_files = [ 'mp3', 'wav', 'ogg' ];
        $ext = $r->file( 'audio' )->getClientOriginalExtension();

        if( ! in_array( $ext , $valid_files  ) ){
            $this->errors[] = 'Invalid file type. Only mp3, wav and ogg files are allowed';
            return false;
        }

        $orig_filename = $r->file( 'audio' )->getClientOriginalName();
        $new_filename = str_random( 24 ).'.'.$ext;

        $destination = '/public/audio/'.Text::convertInt( $this->teacher_id ).'/';
        $url = url( $destination.$new_filename );

        $destination  = public_path().''.$destination;

        if( ! is_dir( $destination )){
            mkdir( $destination , 755 , true );
        }

        $r->file('audio')->move( $destination , $new_filename );
        $file_path = $destination.$new_filename;

        $this->audio_file = $url;
        $this->save();

        return $file_path;
    }
    /**
     * only admin and owner can edit
     */
    public function canEdit()
    {
        if( UserEntity::me()->isAdmin() || $this->teacher_id == UserEntity::me()->id ){
            return true;
        }

        return false;
    }

}
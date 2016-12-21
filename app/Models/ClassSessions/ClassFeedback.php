<?php

namespace App\Models\ClassSessions;

use App\Models\BaseModel;
use App\Models\Financials\Credits;
use App\Models\Users\TeacherPivot;
use App\Models\Users\UserEntity;
use Helpers\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class ClassFeedback extends BaseModel{

    protected $table        = 'feedback';
    protected $primaryKey   = 'feedback_id';
    public $timestamps = false;

    public $fillable    = [ ];

    public function byTeacherId( $teacher_id )
    {
        $feedbacks = static::where( 'f.teacher_id' , $teacher_id )
            ->from( 'feedback as f')
            ->join( 'class_sessions as cs' , 'cs.class_id' , '=' , 'f.class_id'  )
            ->join( 'users as u' , 'u.id' , '=' , 'cs.student_id'  )
         ->limit( 20 )
         ->orderBy( 'added_at' , 'DESC' );

        $this->collection =  $feedbacks->get( ['f.*' , 'cs.student_id' , 'u.first_name' , 'u.last_name' ] );

        return $this;
    }

    public function store( Request $r )
    {
        /**
        $validator = Validator::make( $r->all(), [] );

        if( $validator->fails() ){
            $this->errors[] = '';
            return false;
        }
        ***/

        $this->satisfaction     = $r->st;
        $this->internet_quality = $r->iq;
        $this->pronunciation    = $r->p ;
        $this->teaching_skills  = $r->ts;
        $this->comment = $r->comment;

        if( $this->fid ){
            $this->exists = true;
        }else{
            $this->added_at  = date( 'Y-m-d H:i:s' );
        }

        // get teacher
        $class = ClassSessionEntity::find( $this->class_id );
        $this->teacher_id = $class->teacher_id;

        $this->rating = ( $this->satisfaction + $this->internet_quality +  $this->pronunciation + $this->teaching_skills ) / 4 ;

        if( ! $this->save() ){
            return false;
        }

        // compute teacher rating
        $a = ClassFeedback::from( 'feedback as f' )
            ->where( 'teacher_id' , $this->teacher_id )
            ->avg( 'rating' );

        TeacherPivot::where( 'user_id' , $this->teacher_id )->first();

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
        // for students
        $this->student_short_name = ucwords(strtolower( $this->first_name . ' ' . substr($this->last_name, 0, 1) . '.'));
        $this->student_full_name = ucwords(strtolower( $this->last_name.', '.$this->first_name ) );

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
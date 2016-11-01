<?php

namespace App\Models\Users;

use Helpers\Html;
use Helpers\Text;
use Illuminate\Http\Request;

class TeacherEntity extends UserEntity{

    public function getByUserId( $user_id )
    {
        $teacher = static::where( 'id' , $user_id )
            ->from( 'users as u')
            ->leftJoin( 'teachers as t', 't.user_id' ,'=' ,'u.id' )
            ->first();

        return $teacher;
    }

    public function uploadVoice( Request $r )
    {
        $valid_files = [ 'mp3', 'wav', 'ogg' ];
        $ext = $r->file( 'audio' )->getClientOriginalExtension();

        if( ! in_array( $ext , $valid_files  ) ){
            $this->errors[] = 'Invalid file type. Only mp3, wav and ogg files are allowed';
            return false;
        }

        $orig_filename = $r->file( 'audio' )->getClientOriginalName();
        $new_filename = 'audio_'.str_random( 8 ).'.'.$ext;

        $destination = '/public/user/'.Text::convertInt( $this->id ).'/';
        $url = url( $destination.$new_filename );

        $destination  = public_path().''.$destination;

        if( ! is_dir( $destination )){
            mkdir( $destination , 755 , true );
        }

        $r->file('audio')->move( $destination, $new_filename );
        $file_path  = $destination.$new_filename;

        //$this->audio_file   = $url;
        //$this->save();

        $pivot = TeacherPivot::getByTeacherId( $this->id );
        $pivot->voice_url = $url;
        $pivot->save();

        return $url;
    }

    public function schedule()
    {

    }

    public function vuefyTeacher()
    {
        $this->vuefyUser();
        return $this;
    }

    public function getAge()
    {
        $from = new \DateTime( $this->birthday );
        $to   = new \DateTime('today');
        return $from->diff($to)->y;
    }
}
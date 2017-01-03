<?php

namespace App\Models\Messaging;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class Notes extends BaseModel{

    protected $table        = 'notes';
    protected $primaryKey   = 'note_id';
    public $timestamps = false;

    public $fillable    = [ 'note_id' , 'note' , 'posted_by' , 'note_to'  ];
    public $notes = [];

    public function scopeByUserId( $query , $note_to, Request $r )
    {
        $this->limit =  20;
        $this->page = $r->page ? $r->page : 1;
        $offset = ( $this->page - 1) * $this->limit;
        $order_by = $r->order_by ? $r->order_by : 'posted_at';
        $order_direction = $r->order_direction ? $r->order_direction : 'DESC';

        $this->notes = static::where( 'note_to', $note_to )
            ->from( 'notes as n'  )
            ->join( 'users as u' , 'u.id' ,'=' ,'posted_by')
            ->limit( $this->limit )
            ->offset( $offset )
            ->get( [ 'n.*' , 'u.first_name' , 'u.last_name', 'profile_photo_url' ] );

        return $this;
    }

    public function store( Request $r )
    {
        if( $r->note_id ){
            $this->exists = true;
        }

        $this->fill( $r->all() );
        $this->posted_at = date( 'Y-m-d H:i:s');

        $this->save();

        return $this;
    }

    public function poster()
    {
        return $this->hasOne('App\Models\Users\UserEntity' , 'posted_by' );
    }

    /**
     * Get posted_by details coming from raw model
     *
     * @return static
     */
    public function retrieveRelationships()
    {
        $f = static::where( 'note_id', $this->note_id )
            ->from( 'notes as n'  )
            ->join( 'users as u' , 'u.id' ,'=' ,'posted_by')
            ->first( [ 'n.*' , 'u.first_name' , 'u.last_name', 'profile_photo_url' ] );

        return $f;
    }

    public function vuefy()
    {
        $this->from = $this->first_name.' '.$this->last_name;
        $this->posted_at_human = Carbon::createFromTimestamp( strtotime( $this->posted_at ) )->diffForHumans();
        $subdir = env( 'SUBDIR' ) ? '/'.env( 'SUBDIR' ):'';
        $this->profile_photo_url = $this->profile_photo_url ? $this->profile_photo_url : $subdir.'/public/images/blank_face.png';
        $this->timestamp = strtotime( $this->posted_at );
        return $this;
    }

    public function vuefyNotesCollection()
    {
        $n_arr = [];
        foreach( $this->notes as $n ){
            $n_arr[] = $n->vuefy();
        }

        return $n_arr;
    }

}
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

    public $fillable    = [ ];
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

    public function vuefy()
    {
        $this->from = $this->first_name.' '.$this->last_name;
        $this->posted_at_human = Carbon::createFromTimestamp( strtotime( $this->posted_at ) )->diffForHumans();
        $subdir = env( 'SUBDIR' ) ? '/'.env( 'SUBDIR' ):'';
        $this->profile_photo_url = $this->profile_photo_url ? $this->profile_photo_url : $subdir.'/public/images/blank_face.png';
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
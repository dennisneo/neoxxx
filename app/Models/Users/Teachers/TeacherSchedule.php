<?php

namespace App\Models\Users\Teachers;

use App\Models\BaseModel;
use Carbon\Carbon;
use Helpers\Text;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class TeacherSchedule extends BaseModel{

    protected $table = 'teachers_schedule';
    protected  $primary_Key = 'sid';

    public $timestamps = false;

    protected $fillable = [ 'sid' , 'teacher_id' , 'weekday' , 'from_time' , 'to_time' ];

    public $conflict_message;
    protected $schedules;

    public function store( Request $r , $weekday )
    {
        if( $r->sid ){
            $this->exists = true;
        }

        $this->weekday = $weekday;

        $this->fill( $r->all() );

        // check for conflicts before saving
        if( $record = $this->hasConflict() ){
            $this->conflict_message = ' Schedule for weekday '.$this->weekday.' '.$r->start_time.' to '.$r->end_time.' is in conflict with another schedule';
            return false;
        }

        $this->save();

        return $this->vuefy();
    }

    private function hasConflict( )
    {
        // check if
        $f = static::where( 'weekday' , $this->weekday )
            ->where( 'teacher_id' , $this->teacher_id )
            ->where(function($q){
                $q->whereBetween( 'from_time', [ $this->from_time , $this->to_time ] )
                    ->orWhereBetween( 'to_time' ,  [ $this->from_time , $this->to_time ] );
            })->first();

        return $f ? $f : false;
    }

    public static function rules()
    {
        return [];
    }

    public function vuefy()
    {

        $next_week_day  =   intval( strtotime('next '.$this->weekday ) );

        $this->start_timestamp = ( $next_week_day + ( $this->from_time * 60 ) );
        $this->end_timestamp = ( $next_week_day + ( $this->to_time * 60 ) );

        $this->nw_start_timestamp = $this->start_timestamp + ( 7*24*60*60 ) ;
        $this->nw_end_timestamp   = $this->end_timestamp + ( 7*24*60*60 );
        $this->bookable = true;

        return $this;
    }

    public function getScheduleByTeacherId( $tid , $options = [] )
    {
        $teacher_id  = Text::recoverInt( $tid );

        $schedules = static::where( 'teacher_id' , $teacher_id  );
        $this->schedules =  $schedules->get();

        return $this;
    }

    public function getSchedules()
    {
        return $this->schedules;
    }

    public function vuefySchedules( )
    {
        $s_arr = [];
        foreach( $this->schedules as $s ){
            $s_arr[] = $s->vuefy();
        }

        return $s_arr;
    }
}
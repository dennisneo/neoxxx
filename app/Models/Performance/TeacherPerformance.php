<?php


namespace App\Models\Performance;

use App\Models\BaseModel;
use App\Models\Messaging\Notifications;
use Illuminate\Http\Request;
use Validator;

class TeacherPerformance extends BaseModel{

    public $table = 'performance_record';
    public $primaryKey = 'pid';

    public $timestamps = false;

    protected  $fillable = [ 'pid',  'description' , 'type' , 'warnings' , 'status' , 'occurred_at'  ];

    public function store( Request $r )
    {
        $validator = Validator::make( $r->all(), [] );

        if( $validator->fails() ){
            $this->errors[] = '';
            return false;
        }

        $this->fill( $r->all() );

        if( ! $this->pid  ){
            $this->recorded_at = date( 'Y-m-d H:i:s' );
        }

        if( ! $this->save() ){
            $this->errors[] = 'Failed saving record';
            return false;
        }

        ( new Notifications )->send( 'new performance record' , [ 'sent_to' => $r->teacher_id ] );

        return $this;

    }

    public function getByTeacherId( Request $r )
    {
        $records = static::where( 'teacher_id', $r->teacher_id)->get();
        return $this->vueCollection( $records );
    }

    public function getAll( Request $r )
    {
        $limit  = $r->limit ? $r->limit : 20;
        $page   = $r->page ? $r->page : 1;
        $offset = ($page-1) * $limit;
        $order_by           = $r->order_by ? $r->order_by : 'occurred_at';
        $order_direction    = $r->order_direction ? $r->order_direction : 'ASC';

        $records    = static::from( 'performance_record as pr' )
         ->join( 'users as t' , 'pr.teacher_id', '=' , 't.id' );

        if( $r->teacher_id ){
            $records->where( 'teacher_id', $r->teacher_id );
        }

        $this->total = $records->count();

        $records->limit( $limit );
        $records->offset( $offset );
        $records->orderby( $order_by , $order_direction );

        $records    = $records->get( [ 'pr.*' , 't.first_name' , 't.last_name' ] );

        return $this->vueCollection( $records );
    }

    public function vueCollection( $records )
    {
        $r_array = [];

        foreach( $records as $r ){
            $r_array[] = $r->vuefy();
        }

        return $r_array;
    }

    public function vuefy()
    {
        $this->teacher_name = $this->last_name.', '.$this->first_name;
        $this->occurred_at = date( 'M d, Y' , strtotime( $this->occurred_at ));
        return $this;
    }

}
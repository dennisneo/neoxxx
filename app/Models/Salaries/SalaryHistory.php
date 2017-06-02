<?php

namespace App\Models\Salaries;

use App\Models\BaseModel;
use App\Models\Users\TeacherEntity;
use Illuminate\Http\Request;
use Validator;

class SalaryHistory extends BaseModel
{
    protected $table = 'salary_history';
    protected $primaryKey = 'salary_history_id';
    public $timestamps = false;

    public $fillable = [ 'day_from' , 'day_to' , 'teacher_id' , 'total_minutes' , 'ave_rate',
        'total_income' , 'deductions' , 'prepared_at' , 'status' , 'notes'  ];

    public $appends = [ 'date_coverage' ];

    public function getCollection( Request $r )
    {
        $this->setLpo( $r );
        $this->fields = [ 'a.*' ];

        $this->query = static::from( $this->table.' as a' )
        ->with( 'teacher' );
        // insert conditions here

        $this->total = $this->query->count();

        $this->assignLpo();
        $collection = $this->query->get();

        return $collection;
    }

    public function store( $data )
    {
        $validator = \Validator::make( $data , [
            // validation rules here
        ]);

        if( $validator->fails() ){
            $this->errors = $validator->errors()->all();
            return false;
        }

        $this->fill( $data );
        $pk = $this->primaryKey;

        if( isset( $data[$pk] )  ){
            $this->exists = true;
            $this->$pk = $data[$pk];
        }else{
            $this->prepared_at = date('Y-m-d H:i:s');
        }

        $this->save();

        return $this;
    }

    public function getTotalIncomeAttribute( $value )
    {
        return number_format( $value , 2 );
    }
    
    public function getDateCoverageAttribute()
    {
        return date( 'M d, Y' , strtotime( $this->day_from ) ).' - '.date( 'M d, Y' , strtotime( $this->day_to ) );
    }


    public function teacher()
    {
        return $this->hasOne( TeacherEntity::class,'id','teacher_id');
    }

    public function getDaily( $r )
    {
        if( ! $this->salary_history_id ){
            return [];
        }

        $r->merge( [
            'teacher_id' => $this->teacher_id,
            'day_from'=> $this->day_from,
            'day_to'=>$this->day_to ]
        );

        return ( new SalaryDailyDetails )->getCollection( $r );
    }
}

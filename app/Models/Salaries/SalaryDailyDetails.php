<?php

namespace App\Models\Salaries;

use App\Models\BaseModel;
use Illuminate\Http\Request;
use Validator;

class SalaryDailyDetails extends BaseModel
{
    protected $table = 'salary_daily_details';
    protected $primaryKey = 'salary_id';
    public $timestamps = false;

    public $fillable = [ 'salary_date' , 'teacher_id',
        'total_minutes' , 'rate' , 'day_income', 'deductions'  ];

    public $hidden = [];

    public $appends = [ 'total_time' ];

    public function getCollection( Request $r )
    {

        $this->setLpo( $r );
        $this->fields = [ 'a.*' ];

        $this->query = static::from( $this->table.' as a' );
        if( $r->teacher_id ){
            $this->query->where( 'teacher_id', $r->teacher_id );
        }

        if( $r->day_from && $r->day_to ){
            $this->query->whereBetween( 'salary_date' ,[ $r->day_from , $r->day_to ] );
        }

        $this->total = $this->query->count( $this->primaryKey );

        $this->assignLpo();

        return $this->query->get();

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

    public function getDayIncomeAttribute( $value )
    {
        return number_format( $value , 2 );
    }

    public function getTotalTimeAttribute()
    {
        $hr = sprintf('%02d', floor( $this->total_minutes / 60 ) ) ;
        $min = sprintf('%02d', ( $this->total_minutes % 60 ));
        return $hr.':'.$min;
    }

}

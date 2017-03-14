<?php

namespace App\Models\Financials;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class SalaryDetails extends Model{

    protected $table        = 'salary_details';
    protected $primaryKey   = 'salary_detail_id';
    public $timestamps = false;

    public $fillable    = [ 'salary_detail_id', 'week_from' , 'week_to' , 'teacher_id' , 'total_minutes'
        ,'rate' , 'total_income' , 'deductions', 'status' , 'notes' ];
    private $errors     = [];

    public function store( $data = [] )
    {
        $validator = \Validator::make( $data , [
            'week_from' => 'required',
            'week_to' => 'required',
            'teacher_id' => 'required',
            'rate' => 'required'
        ] );

        if( $validator->fails() ){
            $this->errors = $validator->errors()->all();
            return false;
        }

        $this->fill( $data );
        $pk = $this->primaryKey;

        if( $this->$pk  ){
            $this->exists = true;
        }else{

        }

        $this->save();

        return $this;
    }

    public function getWeekFromAttribute( $value )
    {
        return  date( 'M d, Y', strtotime($value));
    }

    public function getWeekToAttribute( $value )
    {
        return  date( 'M d, Y', strtotime($value));
    }
}
<?php

namespace App\Models\Placement;

use App\Models\BaseModel;
use App\Models\Settings\Settings;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Validator;

class ExamResults extends BaseModel
{
    protected $table        = 'exam_results';
    protected $primaryKey   = 'result_id';
    public $timestamps      = false;

    public $fillable = [ 'cat_id' , 'result_id' , 'session_id'  ];


    public function getByExamSessionId( $session_id ){
        return static::where( 'session_id' , $session_id )
            ->from( 'exam_results as e')
            ->join( 'learning_goals as lg' , 'e.cat_id', '=' ,'lg.goal_id' )
            ->get( ['e.*', 'lg.goal' ]);
    }
}

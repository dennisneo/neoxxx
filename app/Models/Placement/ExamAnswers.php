<?php

namespace App\Models\Placement;

use App\Models\BaseModel;
use App\Models\Settings\Settings;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Validator;

class ExamAnswers extends BaseModel
{
    protected $table        = 'exam_answers';
    protected $primaryKey   = 'aid';
    public $timestamps      = false;

    public $fillable = [ 'question_id' , 'choice_id' , 'session_id'  ];

    public function store( Request $r )
    {

        if( ! $r->choice_id ){
            throw new Exception( trans( 'errors.you_need_select_an_answer' ) );
        }
        if( ! $r->session_id ){
            throw new Exception( trans( 'errors.session_id_not_found' ) );
        }

        $this->fill( $r->all() );
        $this->answered_at = date( 'Y-m-d H:i:s');

        // check if answer is correct
        $choice = QuestionChoices::find( $r->choice_id );
        $this->is_correct = $choice->is_answer ? 1 : 0 ;

        $this->save();

        return $this;
    }
}

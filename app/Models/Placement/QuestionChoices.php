<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 8/1/2016
 * Time: 8:29 PM
 */

namespace App\Models\Placement;

use App\Models\Users\UserEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class QuestionChoices extends Model
{
    protected $table = 'question_choices';
    protected $primaryKey = 'c_id';
    public $timestamps = false;

    public $fillable = ['c_id', 'q_id' , 'choice'];
    private $errors = [];

    public $choices = [];

    public function store( Request $r , $choice )
    {
        $validator = Validator::make( $r->all(), [
            //'choice' => 'required'
        ]);

        if( $validator->fails() ){
            $this->errors[] = 'Choice is required';
            return false;
        }

        $this->fill( $r->all() );
        $this->choice = $choice;

        if( $r->c_id ) {
            $this->exists = true;
        }else{
            $this->added_at = date('Y-m-d H:i:s');
            $this->added_by = UserEntity::me()->id;
        }


        $this->save();

        return $this;
    }

    public function getByQuestionId( $q_id )
    {
        $choices =  static::where('q_id' , $q_id )
            ->orderByRaw('RAND()')
            ->get();


        $this->choices = $choices;
        return $this;
    }

    public function vuefy()
    {
        // do not return answer in vue calls
        unset( $this->is_answer );
        unset( $this->added_by );
        return $this;
    }

    public function vuefyCollection( )
    {
        $c_arr = [];
        foreach( $this->choices as $c ){
            $c_arr[] = $c->vuefy();
        }

        return $c_arr;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

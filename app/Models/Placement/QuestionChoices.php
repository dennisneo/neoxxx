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

    public function store( Request $r , $choice )
    {
        $validator = Validator::make( $r->all(), [
            'choice' => 'required'
        ]);

        if( $validator->fails() ){
            $this->errors[] = 'Choice is required';
            return false;
        }

        $this->fill( $r->all() );

        if( $r->c_id ) {
            $this->exists = true;
        }else{
            $this->added_at = date('Y-m-d H:i:s');
            $this->added_by = UserEntity::me()->id;
        }


        $this->save();

        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

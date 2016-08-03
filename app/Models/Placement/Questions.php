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

class Questions extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'q_id';
    public $timestamps = false;

    public $fillable = ['q_id', 'question' , 'cat_id'];
    private $errors = [];

    public function store( Request $r )
    {
        $validator = Validator::make( $r->all(), [
            'question' => 'required|min:8'
        ]);

        if( $validator->fails() ){
            $this->errors[] = 'Question is required';
            return false;
        }

        $this->fill( $r->all() );

        if( $r->goal_id ) {
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

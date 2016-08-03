<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\LearningGoals;


use App\Models\Users\UserEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class LearningGoals extends Model{

    protected $table        = 'learning_goals';
    protected $primaryKey   = 'goal_id';
    public $timestamps = false;

    public $fillable    = [ 'goal_id','goal','summary','parent_id' ];
    private $errors     =  [];

    public function store( Request $r )
    {
        $validator = Validator::make( $r->all(), [
            'goal' => 'required'
        ]);

        if( $validator->fails() ){
            $this->errors[] = 'Goal is required';
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
        $html = '<ul>';
        foreach( $this->errors as $e ){
            $html .= '<li>'.$e.'</li>';
        }
        $html .= '</ul>';

        return $html;
    }
}
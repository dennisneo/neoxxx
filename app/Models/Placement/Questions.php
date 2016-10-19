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
    private $total = 0;

    public function getQuestions( Request $r )
    {
        $limit = $r->limit ? $r->limit : 20;
        $page = $r->page ? $r->page : 1;
        $offset = ( $page - 1 ) * $limit;

        $orderby = $r->orderby ?  $r->orderby : 'added_at';
        $order_direction = $r->order_direction ?  $r->order_direction : 'DESC';

        $qs  = static::orderby( $orderby , $order_direction );
        $this->total = $qs->count();

        $qs->limit( $limit );
        $qs->offset( $offset );

        return $qs->get();
    }

    public function getChoices( array $question_ids )
    {

        $c_arr = [];

        if( count( $question_ids )){
            $choices  = QuestionChoices::whereIn( 'q_id' ,  $question_ids )
                ->get();
            foreach( $choices as $c ){
                $c_arr[ $c->q_id ][] = $c;
            }
        }

        return $c_arr;
    }

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

    public function getTotal()
    {
     return $this->total;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

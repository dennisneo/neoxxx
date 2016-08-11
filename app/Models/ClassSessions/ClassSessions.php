<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\ClassSessions;


use App\Models\Users\UserEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class ClassSessions extends Model{

    protected $table        = 'class_sessions';
    protected $primaryKey   = 'class_id';
    public $timestamps = false;

    public $fillable    = [ 'class_id' , 'student_id', 'teacher_id' , 'duration' ];
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

        if( $r->class_id ) {

            $this->exists = true;

        }else{
            $this->set_at   = date('Y-m-d H:i:s');
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
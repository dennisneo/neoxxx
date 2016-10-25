<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\LearningGoals;


use App\Models\BaseModel;
use App\Models\Users\UserEntity;
use Illuminate\Http\Request;
use Validator;

class LearningGoalMap extends BaseModel{

    protected $table        = 'learning_goal_map';
    protected $primaryKey   = 'map_id';
    public $timestamps = false;

    public $fillable    = [ 'map_id','learning_goal_id','student_id' ];


    public static function purgeAndSave( Request $r )
    {
        if( empty ( $r->student_id )){
            throw new \Exception( 'Invalid student ID' );
        }

        if( empty( $r->lg ) || ! is_array( $r->lg ) ){
            throw new \Exception( trans('errors.need_select_learning_goals') );
        }

        static::where( 'student_id' , $r->student_id )
            ->delete();

        foreach( $r->lg as $lg ){

            $l = new LearningGoalMap();
            $l->student_id = $r->student_id;
            $l->learning_goal_id = $lg;
            $l->save();

        }

    }

    /**
     * used uding student registration
     */
    public static function checkboxList()
    {
        $l_arr = [];
        $learning_goals = static::all();
        foreach( $learning_goals as $lg ){
            $l_arr[] = '<input type="checkbox" name="lg[]" value="'.$lg->goal_id.'" /> '.$lg->goal;
        }

        return implode( "<br />" , $l_arr );
    }

    public static function getLearningGoalsByStudentId( $student_id )
    {
        return static::where( 'student_id' , $student_id )
            ->get();
    }

}
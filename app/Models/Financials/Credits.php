<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Financials;

use App\Models\Settings\Settings;
use App\Models\Users\UserEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class Credits extends Model{

    protected $table        = 'user_credits';
    protected $primaryKey   = 'map_id';
    public $timestamps = false;

    public $fillable    = [];
    private $errors     = [];

    public function store( Request $r )
    {
        $validator = Validator::make( $r->all(), [
            'goal' => 'required'
        ]);

        if( $validator->fails() ){
            $this->errors[] = '';
            return false;
        }

        $this->fill( $r->all() );
        $pkey = $this->primaryKey;
        if( $r->$pkey ) {
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

    public static function getCreditsByStudentId( $student_id , $return_model = false )
    {
        $credit = static::where( 'student_id' , $student_id )->first();
        if( ! $credit ){
           return false;
        }

        if( $return_model ){
            return $credit;
        }

        return $credit->credits;
    }

    public static function getCreditsByDuration( $duration )
    {
        switch( $duration ){
            case 30:
                if( $s = Settings::getByKey( 'credits_thirty_minutes' ) ){
                    return $s->value;
                }
            break;
            case 60:
                if( $s = Settings::getByKey( 'credits_one_hour' ) ){
                    return $s->value;
                }
            break;
            default:
                return false;
            break;
        }

        return false;
    }

}
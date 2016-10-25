<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 8/1/2016
 * Time: 8:29 PM
 */

namespace App\Models\Settings;

use App\Models\Users\UserEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class Settings extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'setting_id';
    public $timestamps = false;

    public $fillable = [ ];
    private $errors = [];
    private $total = 0;

    public function getTotal()
    {
     return $this->total;
    }

    public static function getByKey( $key , $default = 0 )
    {
         $value =  static::where( 'skey' , $key )
            ->first();
         if( ! $value ){
             return $default;
         }

         return $value->value;
    }

    public static function store( $setting , $value )
    {
        // check if settings is already in db
        // insert one if not
        $s = static::getByKey( $setting );

        if( ! $s ){
            $s = new static;
            $s->skey  = $setting;
        }

        $s->value = $value;
        $s->save();

        return $s;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

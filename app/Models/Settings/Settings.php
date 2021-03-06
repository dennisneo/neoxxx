<?php


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

    /**
     * @param $key
     * @return static
     */
    public static function getObjectByKey( $key )
    {
        $setting =  static::where( 'skey' , $key )
            ->first();

        if( ! $setting ){
            return false;
        }

        return $setting;
    }

    /**
     * Get value by key
     * @param $key
     * @param int $default
     * @return int
     */

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
        $s = static::getObjectByKey( $setting );

        if( ! $s ){
            $s = new static;
            $s->skey  = $setting;
        }

        $s->value = $value;
        $s->save();

        return $s;
    }

    /**
     * return custom message text
     * @return string
     */
    public function customMessageText()
    {
        $str = str_replace( 'message_', '',$this->skey );
        $str = str_replace( '_', ' ',$str );
        return ucwords( $str );
    }

    /**
     * @param $key
     * @param array $values
     * @return mixed|null
     */
    public static function customMessageContent( $key , $values  = [] )
    {
        if( ! $setting  = static::getObjectByKey( $key ) ){
            return null;
        }
        return $setting->mergeValue( $values );
    }

    public function mergeValue( $merge_values )
    {
        $message = $this->value;

        foreach( $merge_values as $k => $v ){
            $message    =   str_replace( "[ $k ]" , $v , $message );
            $message    =   str_replace( "[$k]" , $v , $message );
        }

        return $message;
    }

    public function updateCustomMessages( Request $r )
    {
        $inputs = $r->all();
        foreach( $inputs as $k => $v ){
            if( substr( $k , 0, 8 ) == 'message_' ){
                if( $setting = Settings::getObjectByKey( $k ) ){
                    $setting->value = $v;
                    $setting->save();
                }
            }
        }
    }

    public function getValueAttribute( $value )
    {
        return nl2br( $value );
    }

    public function merge( $message , $merge_array )
    {
        return str_replace( array_keys( $merge_array ) , $merge_array ,  $message );
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

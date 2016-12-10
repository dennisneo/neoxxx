<?php

namespace App\Models\Users\Students;

use App\Models\BaseModel;
use App\Models\Financials\Payments;
use App\Models\Settings\Settings;
use Carbon\Carbon;
use Helpers\Text;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class StudentSettings extends BaseModel{

    protected $table = 'student_settings';
    protected  $primaryKey = 'setting_id';

    public $timestamps = false;

    protected $fillable = [];

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


}
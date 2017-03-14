<?php

namespace App\Models\Financials;

use App\Models\BaseModel;
use App\Models\Users\Students\StudentCredits;
use Helpers\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class PaymentKeys extends BaseModel{

    protected $table        = 'payment_keys';
    protected $primaryKey   = 'key_id';
    public $timestamps = false;

    public $fillable    = [];

    public static function check( $user_id , $skey )
    {
        $key = static::where( 'user_id', $user_id )
            ->where( 'skey' , $skey )
            ->first();

        return $key;

    }

    public function generate( $user_id )
    {
        // @TODO garbage collection 20%

        $key = new static;
        $key->user_id = $user_id;
        $key->skey  = str_random( 12 );
        $key->created_at = date('Y-m-d H:i:s');

        $key->save();

        return $key;

    }
}
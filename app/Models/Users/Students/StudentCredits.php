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

class StudentCredits extends BaseModel{

    protected $table = 'student_credits';
    protected  $primaryKey = 'map_id';

    public $timestamps = false;

    protected $fillable = [];

    public function add( Request $r ){

        if( empty( $this->map_id ) ){
           throw new Exception('StudentCredits model needs to have valid id');
        }

        $payment = new Payments();
        if( $payment->execute( $r ) ){
            //\DB::beginTransaction();
            $this->credits = $this->credits + $r->credits;
            $this->save();
        }



        return $this;
    }

    /**
     * @param $student_id
     * @param bool $return_model
     * @return StudentCredits
     */
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
            case 20:
                if( $value = Settings::getByKey( 'credits_twenty_minutes' ) ){
                    return $value;
                }
                break;
            case 40:
                if( $value = Settings::getByKey( 'credits_fourty_minutes' ) ){
                    return $value;
                }
                break;
            case 60:
                if( $value = Settings::getByKey( 'credits_one_hour' ) ){
                    return $value;
                }
                break;
            default:
                return false;
                break;
        }

        return false;
    }



}
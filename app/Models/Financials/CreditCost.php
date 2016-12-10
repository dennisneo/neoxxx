<?php

namespace App\Models\Financials;

use App\Models\BaseModel;
use Helpers\Alipay;
use Illuminate\Http\Request;
use Validator;

class CreditCost extends BaseModel{

    protected $table        = 'credit_cost';
    protected $primaryKey   = 'cost_id';
    public $timestamps = false;

    public $fillable    = [];

    public function getAll()
    {
        $cc = static::all();
        $this->collection = $cc;

        return $this;
    }

    public function vuefy()
    {
        $_input_charset = "utf-8";
        $sign_type = "MD5";
        $notify_url = env('ALIPAY_NOTIFY_URL');//first you should change this url. if you want to know the function of the notify_url, you should read the alipay overseas order receiving interface file which we already offered you
        $return_url = env('ALIPAY_RETURN_URL');

        if( env('ALIPAY_LIVE') ){
            $partner        = env( 'ALIPAY_ID' );//fill with the partnerID which we already offered you (required fields)
            $security_code  = env( 'ALIPAY_SECURITY_ID' );//fill with the security key which we already offered you (required fields)
            $transport= "https";
        }else{
            $partner        = "2088101122136241";//fill with the partnerID which we already offered you (required fields)
            $security_code  = "760bdzec6y9goq7ctyx96ezkz78287de";//fill with the security key which we already offered you (required fields)
            $transport= "http";
        }

        $parameter = array(
            "service" => "create_forex_trade", //this is the service name
            "partner" =>$partner,
            "return_url" =>$return_url,
            "notify_url" =>$notify_url,
            "_input_charset" => $_input_charset,
            "subject" => "NEO English Learning", //subject is the name of the product, you'd better change it
            "body" =>"Test 1234",  //body is the description of the product , you'd beeter change it
            "out_trade_no" => time(),
            "total_fee" => $this->cost, //the price of products
            "currency"=>"USD", // change it as the currency which you used on your website
        );

        // only alipay for now
        $alipay = new Alipay\AlipayService( $parameter,$security_code,$sign_type);
        $this->payment_url =    $alipay->create_url();
        return $this;
    }


}
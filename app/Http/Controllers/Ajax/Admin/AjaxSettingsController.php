<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\Financials\CreditCost;
use App\Models\Settings\Settings;
use Illuminate\Http\Request;

class AjaxSettingsController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function saveRates( Request $r )
    {
        Settings::store( 'rate_local_from', $r->rate_local_from );
        Settings::store( 'rate_local_to', $r->rate_local_to );
        Settings::store( 'rate_native_from', $r->rate_native_from );
        Settings::store( 'rate_native_to', $r->rate_native_to );
        Settings::store( 'rate_filipino_from', $r->rate_filipino_from );
        Settings::store( 'rate_filipino_to', $r->rate_filipino_to );

        return [
            'success' =>true,

        ];
    }

    public function saveCustomMessages( Request $r )
    {
        $settings = new Settings();
        $settings->updateCustomMessages( $r );

        return [
            'success' =>  true
        ];
    }

    public function getCreditCost( Request $r )
    {
        if( ! $credit_cost = CreditCost::find( $r->ccid ) ){
            return [
                'success' =>false,
                'message' => 'Credit cost not found'
            ];
        }

        return [
            'success' =>true,
            'cc' => $credit_cost
        ];

    }

    public function saveCreditsCost( Request $r )
    {
        if( ! is_numeric($r->cost )){
            return [
                'success' =>false,
                'message' => 'Cost value must be numeric'
            ];
        }

        if( ! is_numeric( $r->credits )){
            return [
                'success' =>false,
                'message' => 'Credit value must be numeric'
            ];
        }

        $cc = new CreditCost();
        if( $r->cost_id ){
            $cc = CreditCost::find( $r->cost_id );
        }
        $cc->credits = $r->credits;
        $cc->cost = $r->cost;
        $cc->desc = $r->desc;
        $cc->save();

        return [
            'success' =>true,
            'credits_cost' => $cc
        ];

    }

    public function deleteCreditsCost( Request $r )
    {
        if( ! $credits_cost = CreditCost::find( $r->ccid ) ){
            return [
                'success' =>false,
                'message' => 'Credit cost not found'
            ];
        }

        $credits_cost->delete();

        return [
            'success' =>true,
            'ccid' => $r->ccid
        ];
    }

    public function getCreditCostAll( Request $r )
    {
        $credits_cost = ( new CreditCost )->getAll()->vuefyThisCollection();

        return [
            'success' =>true,
            'credits_cost' => $credits_cost
        ];
    }

    public function saveSettings( Request $r )
    {
        foreach( $r->all() as $k => $v ){
            if( substr( $k, 0 , 9 ) == 'settings_'){
                $key = str_replace( 'settings_', '' , $k );
                Settings::store( $key , $v );
            }
        }
        return [
            'success' => true    
        ];
    }
}
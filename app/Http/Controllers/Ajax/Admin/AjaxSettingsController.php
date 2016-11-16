<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\Financials\CreditCost;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Placement\QuestionChoices;
use App\Models\Placement\Questions;
use App\Models\Settings\Settings;
use Illuminate\Http\Request;

class AjaxSettingsController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
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
        $credits_cost = CreditCost::all();

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
<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
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
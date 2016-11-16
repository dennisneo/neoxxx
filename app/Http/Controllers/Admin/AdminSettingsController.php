<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers\Admin;

use App\Models\Settings\Settings;
use App\Models\Users\Applicants;
use Helpers\Html;
use Illuminate\Http\Request;

class AdminSettingsController extends AdminBaseController{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $settings    = [];
        $ss = Settings::all();

        foreach( $ss as $s ){
            $settings[ $s->skey ] = $s->value;
        }

        $settings = json_decode( json_encode( $settings ) );

        $this->layout->content = view('admin.settings.settings_index')
        ->with( 'settings' , $settings);

        Html::instance()->addScript( 'public/app/admin/settings/settings_index.js' );
        Html::loadToastr();

        return $this->layout;
    }


}
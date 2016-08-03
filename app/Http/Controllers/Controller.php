<?php

namespace App\Http\Controllers;

use App\Models\Users\UserEntity;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected $theme;
    protected $theme_path;
    protected $layout_path;
    public $layout;

    public function __construct()
    {
        $this->setViews();

    }

    public function setViews()
    {
        $this->theme = env( 'APP_THEME' );
        $this->theme_path = __DIR__.'/../Views/themes/'.$this->theme.'/';

        view()->addLocation( $this->theme_path );
    }

    /**
     * use this only on controllers that need authorized persons to access
     */
    public function setUser()
    {
        if(  \Auth::check() ){
           UserEntity::setupMe( \Auth::user() );
           return UserEntity::me();
        }

        return false;
    }

}

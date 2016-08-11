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

    public function __construct( $theme = null )
    {
        $this->setLayout( $theme );
    }

    /**
     * allows controllers to change layouts
     * @param null $theme
     */
    public function setLayout( $theme = null )
    {
        // set the theme
        $this->setTheme( $theme );
        // include all views to the path
        $this->setViews();
        // define the default layout
        $this->layout = view( 'layouts.'.$this->theme.'_default' );
    }

    /**
     * override the default theme
     * in env( 'APP_THEME' )
     */

    private function setTheme( $theme = null )
    {
        $this->theme = $theme ? $theme : env( 'APP_THEME' );
    }

    private function setViews()
    {
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

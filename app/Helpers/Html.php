<?php

namespace Helpers;

use Collective\Html\HtmlFacade;

class Html extends HtmlFacade{
	
	protected $scripts  = array(); 
	protected $styles   = array();
	protected static $instances = array();
	
	public static function instance( $key = 'default' ){		
		if( isset( static::$instances[ $key ] ) ){
			return static::$instances[ $key ];
		}
		
		return static::$instances[ $key ] = new HTML;
	}

	/**
	 * add single page scripts
	 * @param string $script_path
	 */
	public function addScript( $script_path ){
		$this->scripts[] = 	$script_path;
	}
	
	/**
	 * add style 
	 * @param string $script_path
	 */
	public function addStyle( $style_path ){
		$this->styles[] = 	$style_path;
	}
	
	public function getScripts(){
		return $this->scripts;
	}
	
	public function getStyles(){
		return $this->styles;
	}

	public function renderScript( $path ){
		$subdir = env('SUBDIR') ? '/'.env('SUBDIR'): '';
		$path = substr( $path , 0 , 1 ) == '/' ? $path : '/'.$path;
		return '<script src="'.$subdir.$path.'"></script>'."\r";
	}

	public function renderStyle( $path ){
		$subdir = env('SUBDIR') ? '/'.env('SUBDIR'): '';
		$path = substr( $path , 0 , 1 ) == '/' ? $path : '/'.$path;
		return '<link rel="stylesheet" href="'.$subdir.$path.'">'."\r";
	}

	public function renderPageScripts(){
		$html = array();		
		foreach( $this->getScripts() as $script ){
			$html[] = $this->renderScript( $script );
		}
		return implode( "" , $html );
	}
	
	public function renderPageStyles(){
		$html = array();		
		foreach( $this->getStyles() as $style ){
			$html[] = $this->renderStyle( $style );
		}
		return implode( '' , $html );
	}

	public static function loadFlexslider()
	{
		static::instance()->addScript( '/themes/prime/js/jquery.flexslider-min.js' );
	}

	public static function loadCaption()
	{
		Html::instance()->addScript( '/plugins/captions/jquery.caption.min.js' );
		Html::instance()->addStyle( '/plugins/captions/captionjs.min.css' );
	}


	public static function loadDateCombo()
	{
		static::instance()->addScript( '/public/plugins/datecombo/moment.js' );
		static::instance()->addScript( '/public/plugins/datecombo/combodate.js' );
	}

	public static function loadToastr()
	{
		static::instance()->addStyle( '/public/plugins/toastr/toastr.min.css' );
		static::instance()->addScript( '/public/plugins/toastr/toastr.min.js' );
	}

	public static function loadBlockUI()
	{
		static::instance()->addScript( '/themes/v1/plugins/blockUI/jquery.blockUI.js' );
	}

	public static function loadJQueryUI()
	{
		static::instance()->addScript( '/js/jquery_ui/jquery-ui.min.js' );
		static::instance()->addStyle( '/js/jquery_ui/jquery-ui.min.css' );

	}

	public static function loadDatepicker()
	{
		static::instance()->addScript( '/public/plugins/datepicker/jquery-ui-datepicker.js' );
		static::instance()->addStyle( '/public/plugins/datepicker/datepicker.css' );
	}

	public static function loadSummernote()
	{
		static::instance()->addScript( '/plugins/summernote/dist/summernote.min.js' );
		static::instance()->addStyle( '/plugins/summernote/dist/summernote.css' );
	}

	public static function simpleModal()
	{
		Html::instance()->addScript( '/public/js/jquery.simplemodal.1.4.2.min.js' );
		Html::instance()->addStyle( '/public/css/simplemodal.css' );
	}

	public static function loadAutoComplete()
	{
		Html::instance()->addScript( '/js/jquery_plugins/jquery.autocomplete.js' );
		Html::instance()->addStyle( '/css/autocomplete.css' );
	}

	public static function loadFileupload(){
		Html::instance()->addScript( '/themes/v1/plugins/jQuery-File-Upload/js/vendor/jquery.ui.widget.js' );
		Html::instance()->addScript( '/themes/v1/plugins/jQuery-File-Upload/js/jquery.iframe-transport.js' );
		Html::instance()->addScript( '/themes/v1/plugins/jQuery-File-Upload/js/jquery.fileupload.js' );
	}


	public static function placeholderImage(){
		return '/images/placeholder.jpg';
	}


	public static function generateErrorMessage( $errors ){
		$html = '<ul>';
		 foreach( $errors as $e ){
			 $html .= '<li>'.$e.'</li>';
		 }
		$html .= '</ul>';
		return $html;
	}

	public static function getCountries()
	{

	}
}
<?php

namespace Helpers;

use Collective\Html\HtmlFacade;
use DateTimeZone;
use DateTime;


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

	public static function absPath( $path ){

		$subdir = config( 'env.SUBDIR' ) ? '/'.config( 'env.SUBDIR' ): '';
		$path = substr( $path , 0 ,1 ) != '/' ? '/'.$path : $path;
		return $subdir.$path;
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

	public static function timezoneSelect( $default = 8 ){
		$tz = [
			'-12'=>'(GMT-12:00) International Date Line West',
			'-11'=>'(GMT-11:00) Midway Island, Samoa',
			'-10'=>'(GMT-10:00) Hawaii',
			'-9'=>'(GMT-9:00) Alaska',
			'-8'=>'(GMT-8:00) Pacific Time (US & Canada)',
			'-7'=>'(GMT-7:00) Mountain Time , Arizona (US & Canada)',
			'-6'=>'(GMT-6:00) Central Time (US & Canada)',
			'-5'=>'(GMT-5:00) Eastern Time (US & Canada)',
			'-4'=>'(GMT-4:00) Atlantic Time (Canada), Caracas, La Paz',
			'-3'=>'(GMT-3:00) Brasilia, Buenos Aires, Georgetown',
			'-2'=>'(GMT-2:00) Mid-Atlantic',
			'-1'=>'(GMT-1:00) Cape Verde Island',
			'0'=>'(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London',
			'1'=>'(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
			'2'=>'(GMT+02:00) Athens, Beirut, Bucharest, Cairo, Istanbul',
			'3'=>'(GMT+03:00) Kuwait, Riyadh, Baghdad, Moscow',
			'4'=>'(GMT+04:00) Abu Dhabi, Muscat',
			'5'=>'(GMT+05:00) Islamabad, Karachi, Tashkent',
			'6'=>'(GMT+06:00) Almaty, Astana, Dhaka, Novosibirsk',
			'7'=>'(GMT+07:00) Bangkok, Hanoi, Jakarta',
			'8'=>'(GMT+08:00) Manila,Beijing, Kuala Lumpur, Singapore, Hong Kong',
			'9'=>'(GMT+09:00) Osaka, Seoul, Tokyo',
			'10'=>'(GMT+10:00) Canberra, Melbourne, Sydney, Brisbane',
			'11'=>'(GMT+11:00) Magadan, Solomon Is., New Caledonia',
			'12'=>'(GMT+12:00) Auckland, Fiji, Marshall Island',
		];

		//view()->addLocation( __DIR__.'/view/' );
		//return view( 'timezone' );
		return \Form::select( 'timezone' , $tz , $default , [ 'class' => 'form-control' , 'id' => 'timezone' ]);
	}
	public static function displayTimeZone( $timezone ){
		if( $timezone < 0 ){
			return 'GMT-'.sprintf('%02d', $timezone);
		}
		if( $timezone > 0 ){
			return 'GMT+'.sprintf('%02d', $timezone);
		}
		if( $timezone == 0 ){
			return 'GMT';
		}
	}
}
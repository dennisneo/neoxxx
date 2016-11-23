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

		$subdir = env( 'SUBDIR' ) ? '/'.env( 'SUBDIR' ): '';
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
		$s_array = [];

		foreach( $this->getScripts() as $script ){
			if( in_array( $script , $s_array) ){
				continue;
			}
			$s_array[] = $script;
			$html[] = $this->renderScript( $script );
		}

		return implode( "" , $html );
	}
	
	public function renderPageStyles(){
		$html = array();
		$s_array = [];

		foreach( $this->getStyles() as $style ){
			if( in_array( $style , $s_array) ){
				continue;
			}
			$s_array[] = $style;
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
		//static::instance()->addScript( '/themes/v1/plugins/blockUI/jquery.blockUI.js' );
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
		static::instance()->addStyle( '/public/css/jquery-ui/base.css' );
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
		Html::instance()->addScript( '/public/plugins/autocomplete/jquery.autocomplete.js' );
		Html::instance()->addStyle( '/public/plugins/autocomplete/autocomplete.css' );
	}

	public static function loadFullCalendar()
	{
		Html::instance()->addScript( '/public/plugins/fullcalendar/moment.js' );
		Html::instance()->addScript( '/public/plugins/fullcalendar/fullcalendar.min.js' );
		Html::instance()->addStyle( '/public/plugins/fullcalendar/fullcalendar.min.css' );
		//Html::instance()->addStyle( '/public/plugins/fullcalendar/fullcalendar.print.css' );

	}

	public static function loadFileupload( $file_type = null ){
		Html::instance()->addScript( '/public/plugins/fileupload/js/vendor/jquery.ui.widget.js' );
		Html::instance()->addScript( '/public/plugins/fileupload/js/jquery.iframe-transport.js' );
		Html::instance()->addScript( '/public/plugins/fileupload/js/jquery.fileupload.js' );
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

	public static function timezoneSelect( $default ='Asia/Singapore' ){
		$tz = [
			'Pacific/Midway'=>'(GMT-11:00) Midway Island, Samoa',
			'Pacific/Honolulu'=>'(GMT-10:00) Hawaii',
			'America/Anchorage'=>'(GMT-9:00) Alaska',
			'America/Los_Angeles'=>'(GMT-8:00) Pacific Time (US & Canada)',
			'America/Denver'=>'(GMT-7:00) Mountain Time , Arizona (US & Canada)',
			'America/Chicago'=>'(GMT-6:00) Central Time (US & Canada)',
			'America/New_York'=>'(GMT-5:00) Eastern Time (US & Canada)',
			'America/Caracas'=>'(GMT-4:00) Atlantic Time (Canada), Caracas, La Paz',
			'America/Argentina/Buenos_Aires'=>'(GMT-3:00) Brasilia, Buenos Aires, Georgetown',
			'Atlantic/Stanley'=>'(GMT-2:00) Mid-Atlantic',
			'Atlantic/Cape_Verde'=>'(GMT-1:00) Cape Verde Island',
			'Europe/Dublin'=>'(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London',
			'Europe/Berlin'=>'(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
			'Asia/Beirut'=>'(GMT+02:00) Athens, Beirut, Bucharest, Cairo, Istanbul',
			'Asia/Kuwait'=>'(GMT+03:00) Kuwait, Riyadh, Baghdad, Moscow',
			'Asia/Muscat'=>'(GMT+04:00) Abu Dhabi, Muscat',
			'Asia/Karachi'=>'(GMT+05:00) Islamabad, Karachi, Tashkent',
			'Asia/Almaty'=>'(GMT+06:00) Almaty, Astana, Dhaka, Novosibirsk',
			'Asia/Bangkok'=>'(GMT+07:00) Bangkok, Hanoi, Jakarta',
			'Asia/Singapore'=>'(GMT+08:00) Beijing, Hong Kong, Singapore, Manila,  Kuala Lumpur',
			'Asia/Seoul'=>'(GMT+09:00) Osaka, Seoul, Tokyo',
			'Australia/Melbourne'=>'(GMT+10:00) Canberra, Melbourne, Sydney, Brisbane',
			'Asia/Vladivosto'=>'(GMT+11:00) Magadan, Solomon Is., New Caledonia',
			'Pacific/Auckland'=>'(GMT+12:00) Auckland, Fiji, Marshall Island',
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
<?php

namespace Helpers\Alipay;

class AlipayService {

	var $gateway = "https://mapi.alipay.com/gateway.do?"; //this is the gateway of the alipay, don't change it 
	var $parameter;       
	var $security_code;  	
	var $mysign;
	public $transport;

	public function __construct($parameter,$security_code,$sign_type = "MD5",$transport= "https") {

		$this->parameter      = $this->para_filter($parameter);

		$this->security_code  = $security_code;
		$this->sign_type      = $sign_type;
		$this->mysign         = '';
		$this->transport      = $transport;
		if($parameter['_input_charset'] == ""){
			$this->parameter['_input_charset']='GBK';
		}

		$this->gateway = "https://openapi.alipaydev.com/gateway.do?";

		if($this->transport == "https") {
			//$this->gateway = "https://mapi.alipay.com/gateway.do?";
		} else {
			//$this->gateway = "https://mapi.alipay.com/gateway.do?";
		}
		$sort_array = array();
		$arg = "";
		$sort_array = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".$this->charset_encode($val,$this->parameter['_input_charset'])."&";
		}
		$prestr = substr($arg,0,count($arg)-2);
		$this->mysign = $this->sign($prestr.$this->security_code);
	}


	function create_url() {
		$url = $this->gateway;
		$sort_array = array();
		$arg = "";

		$sort_array = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".urlencode($this->charset_encode($val,$this->parameter['_input_charset']))."&";
		}
		$url.= $arg."sign=" .$this->mysign ."&sign_type=".$this->sign_type;
		return $url;

	}

	function arg_sort($array) {
		ksort($array);
		reset($array);
		return $array;

	}

	function sign($prestr) {
		$mysign = "";
		if($this->sign_type == 'MD5') {
			$mysign = md5($prestr);
		}elseif($this->sign_type =='DSA') {
			die("DSA ");
		}else {
			die(" ".$this->sign_type." ");
		}
		return $mysign;

	}
	function para_filter($parameter) {
		$para = array();

		while (list ($key, $val) = each ($parameter)) {
			if($key == "sign" || $key == "sign_type" || $val == ""){
				continue;
			} else{
				$para[$key] = $parameter[$key];
			}

		}

		return $para;
	}

	function charset_encode($input,$_output_charset ,$_input_charset ="GBK" ) {
		$output = "";
		if(!isset($_output_charset) )$_output_charset  = $this->parameter['_input_charset '];
		if($_input_charset == $_output_charset || $input ==null) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")){
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset change.");
		return $output;
	}
	

}


?>
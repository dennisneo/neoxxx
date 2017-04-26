<?php

namespace Helpers;


class DateTimeHelper {

	/**
	 * Converts server time to the time of the user base on his timezone
	 *
	 * @param $time integer
	 * @param $timezone
	 * @return integer
	 *
	 */
	public static function serverTimeToTimezone( $time , $timezone )
	{
		$c_time = $time;
		// do the conversion here !!!
		return $c_time;
	}

	/**
	 * converts the time of user adjusted to his timezone to server time
	 * @param $time
	 */
	public static function timezoneToServerTime( $time )
	{

	}

	public static function timeOffsetFromAsiaManila( $timezone )
	{
		$dateTimeZoneManila 	= new \DateTimeZone( "Asia/Singapore");
		$dateTimeZoneUser 		= new \DateTimeZone( $timezone );

		$dateTimeManila 		= new \DateTime("now", $dateTimeZoneManila );
		$dateTimeUser 			= new \DateTime("now", $dateTimeZoneUser );

		$offset = - ( $dateTimeManila->getOffset() - $dateTimeUser->getOffset() );

		return $offset;
	}

	public static function timeDropdown()
	{
		$mins = [ 0, 20, 40 ];
		$hr = [ 1,2,3,4,5,6,7,8,9,10,11,12 ];

		//\Form::select( 'hr' , $hr,'' , [ 'class' =>'form-control'] );
		//\Form::select( 'min' , $mins , '' , [ 'class' =>'form-control'] );

		for( $i = 360; $i <= 1320; $i = $i + 20 ){

		}
	}

	public static function daysOfTheWeek()
	{
		return [
			'Sun' => 'Sun', 'Mon' => 'Mon', 'Tue'=> 'Tue', 'Wed'=>'Wed' , 'Thu' => 'Thu', 'Fri'=> 'Fri' , 'Sat' => 'Sat'
		];
	}

	public static function timeTrList()
	{
		$mins = [0, 20, 40];
		$hr = [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22];

		$tr_arr = [];
		foreach ($hr as $v) {
			$ampm = $v < 12 ? 'am' : 'pm';
			$v = $v > 12 ? ($v - 12) : $v;
			$tr_arr[] = $v . ':00 ' . $ampm;
		}

		return $tr_arr;
	}

	/**
	 * Shows a 7 day range for teacher availability
	 *
	 * @param string $timezone
	 * @return array
	 */
	public static function nextSevenDays( $timezone = 'Asia/Singapore', $start = 'now' )
	{
		$date 	= 	new \DateTime( $start , new \DateTimeZone( $timezone ) );
		$d_arr =[];
		for( $i = 0 ; $i < 7 ; $i++ ){
			$date->add(new \DateInterval('P1D'));
			$d_arr[] =  $date->format('D M d');
		}

		return $d_arr;
	}

	/**
	 * get the current time base on timezone
	 * @param $timezone
	 * @return \DateTime
	 */
	public static function now( $timezone = 'Asia/Singapore' )
	{
		return new \DateTime( 'now' , new \DateTimeZone( $timezone ) );
	}

	/**
	 * given time format H:m ampm returns the numeric minute value
	 * @param $time
	 */
	public static function convertToMinutes( $time )
	{
		$min = null;
		$ampm = null;

		sscanf( $time , "%d:%d %s" , $hr , $min , $ampm );

		if( $ampm == 'pm' ){
			if( $hr != 12 ){
				$hr = $hr + 12;
			}
		}

		return ( $hr*60 ) +  $min;

	}

	public static function intToMinutes( $int )
	{
		$hr  =  floor( $int / 60 );
		if( $hr > 12 ){
			$hr = $hr - 12;
		}

		$min = $int % 60;

		$ampm = floor( $int / 60 ) > 11 ? 'pm' : 'am';

		return $hr.':'.sprintf("%02d",  $min ).' '.$ampm;

	}

}

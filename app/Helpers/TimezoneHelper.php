<?php

namespace Helpers;

use Faker\Provider\tr_TR\DateTime;

class TimezoneHelper {

	public static function getCurrentUserTime( $timezone )
	{
		$date = new DateTime("now", new \DateTimeZone( $timezone ) );
		return $date->format('Y-m-d H:i:s');
	}

}

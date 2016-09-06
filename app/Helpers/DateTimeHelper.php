<?php

namespace Helpers;

class DateTimeHelper {

	public static function timeDropdown()
	{
		$mins = [ 0, 15, 30 , 45 ];
		$hr = [ 1,2,3,4,5,6,7,8,9,10,11,12 ];

		\Form::select( 'hr' , $hr,'' , [ 'class' =>'form-control'] );
		\Form::select( 'min' , $mins , '' , [ 'class' =>'form-control'] );
	}

}

<?php

Route::group( ['prefix' => 'teacher' , 'middleware' => 'auth' ] , function(){
    Route::get( 'dashboard', 'Teacher\TeacherDashboardController@index' );
    Route::get( 'schedule', 'Teacher\TeacherScheduleController@index' );
});





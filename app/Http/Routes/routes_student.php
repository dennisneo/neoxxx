<?php


Route::group( [ 'prefix' => 'student' , 'as'=> 'student' , 'middleware' =>'auth' ] ,function(){
    Route::get( 'dashboard', 'Student\StudentDashboardController@index' );
    Route::get( 'newsession', 'Student\StudentSessionsController@newSession' );
});



<?php


Route::group( [ 'prefix' => 'student' , 'as'=> 'student' , 'middleware' =>'auth' ] ,function(){

    Route::get( 'dashboard', 'Student\StudentDashboardController@index' );
    Route::get( 'newsession', 'Student\StudentSessionsController@newSession' );
    Route::get( 'teachers', 'Student\StudentDashboardController@teachers' );
    // show teacher view on student perspective
    Route::get( 't/{id}', 'Student\StudentDashboardController@teacher' );
    Route::get( 'sdetails', 'Student\StudentSessionsController@classSessionDetails' );
    Route::get( 'credits/buy', 'Student\StudentDashboardController@buyCredits' );

});



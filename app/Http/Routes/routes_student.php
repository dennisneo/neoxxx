<?php


Route::group( [ 'prefix' => 'student' , 'as'=> 'student' , 'middleware' =>'auth' ] ,function(){

    // getting started
    Route::get( 'getting_started', 'Student\StudentDashboardController@gettingStarted' );

    Route::get( 'dashboard', 'Student\StudentDashboardController@index' );
    Route::get( 'newsession', 'Student\StudentSessionsController@newSession' );
    Route::get( 'teachers', 'Student\StudentDashboardController@teachers' );
    Route::get( 'schedule', 'Student\StudentScheduleController@index' );
    Route::get( 'placement_exam', 'Student\StudentPlacementExamController@index' );
    Route::get( 'learning_goals', 'Student\StudentLearningGoalsController@index' );

    Route::get( 'pe/start', 'Student\StudentPlacementExamController@start' );

    // show teacher view on student perspective
    Route::get( 't/{id}', 'Student\StudentDashboardController@teacher' );
    Route::get( 'sdetails', 'Student\StudentSessionsController@classSessionDetails' );
    Route::get( 'credits/buy', 'Student\StudentDashboardController@buyCredits' );

});



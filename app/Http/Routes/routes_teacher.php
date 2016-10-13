<?php

Route::group( ['prefix' => 'teacher' , 'middleware' => 'auth' ] , function(){

    Route::get( 'dashboard', 'Teacher\TeacherDashboardController@index' );
    Route::get( 'schedule', 'Teacher\TeacherController@index' );
    Route::get( 'evaluation', 'Teacher\TeacherController@evaluation' );
    Route::get( 'salary', 'Teacher\TeacherController@salary' );
    Route::get( 'performance', 'Teacher\TeacherController@performance' );

});





<?php

Route::group( [ 'prefix' => 'admin' , 'as'=> 'admin' , 'middleware' =>'auth' ] ,function(){

    Route::get( 'dashboard', 'Admin\AdminController@dashboard' );

    Route::get( 'schedules', 'Admin\AdminSchedulesController@index' );

    /************ Learning Goals section *********/
    Route::get( 'learning-goals', 'Admin\AdminLearningGoalsController@index' );

    /************ Applicants Section *****************/
    Route::get( 'applicants', 'Admin\AdminApplicantsController@index' );
    Route::get( 'applicant/{id}', 'Admin\AdminApplicantsController@applicant' );

    /************ Exam management section *****************/
    Route::get( 'pe', 'Admin\AdminPlacementExamController@index' );
    Route::get( 'pe/q', 'Admin\AdminPlacementExamController@question' );

    /************ Teachers section *****************/
    Route::get( 'teachers', 'Admin\AdminTeachersController@index' );
    Route::get( 'teacher/{id}', 'Admin\AdminTeachersController@teacher' );
    Route::get( 'teacher/edit/profile/{id}', 'Admin\AdminTeachersController@editTeacherProfile' );
    Route::get( 'teacher/schedule/{id}', 'Admin\AdminTeachersController@manageTeacherSchedule' );

    Route::get( 'records', 'Admin\AdminTeachersController@performanceRecords' );
    Route::get( 'records/{teacher_id}', 'Admin\AdminTeachersController@performanceRecords' );

    /************ Teachers section *****************/
    Route::get( 'students', 'Admin\AdminStudentsController@index' );

    Route::get( 'payment_history', 'Admin\AdminFinancialsController@payment_history' );
    Route::get( 'salaries', 'Admin\AdminFinancialsController@salaries' );


    Route::get( 'settings', 'Admin\AdminSettingsController@index' );
});



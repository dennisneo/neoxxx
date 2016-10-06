<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 8/5/2016
 * Time: 8:03 AM
 */

Route::group( [ 'prefix' => 'admin' , 'as'=> 'admin' , 'middleware' =>'auth' ] ,function(){

    Route::get( 'dashboard', 'Admin\AdminController@dashboard' );

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

    /************ Teachers section *****************/
    Route::get( 'students', 'Admin\AdminStudentsController@index' );

    Route::get( 'settings', 'Admin\AdminSettingsController@index' );
});


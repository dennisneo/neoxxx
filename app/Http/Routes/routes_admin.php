<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 8/5/2016
 * Time: 8:03 AM
 */


Route::get( 'admin/dashboard', 'Admin\AdminController@dashboard' );

/************ Learning Goals section *********/
Route::get( 'admin/learning-goals', 'Admin\AdminLearningGoalsController@index' );

/************ Exam management section *****************/
Route::get( 'admin/pe', 'Admin\AdminPlacementExamController@index' );
Route::get( 'admin/pe/q', 'Admin\AdminPlacementExamController@question' );

/************ Applicants Section *****************/
Route::get( 'admin/applicants', 'Admin\AdminApplicantsController@index' );
Route::get( 'admin/applicant/{id}', 'Admin\AdminApplicantsController@applicant' );


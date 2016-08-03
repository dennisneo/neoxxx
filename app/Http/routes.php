<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get( '/', function (){
    return view('welcome');
});

Route::get( 'student/application', 'FrontController@studentLandingPage' );
Route::get( 'teacher', 'FrontController@applicantLandingPage' );
Route::post( 'landing', 'FrontController@applicantLandingPage' );
Route::get( 'login', 'FrontController@login' );
Route::post( 'login', 'FrontController@login' );

Route::get( 'admin/dashboard', 'Admin\AdminController@dashboard' );
Route::get( 'admin/learning-goals', 'Admin\AdminLearningGoalsController@index' );
Route::get( 'admin/pe', 'Admin\AdminPlacementExamController@index' );
Route::get( 'admin/pe/q', 'Admin\AdminPlacementExamController@question' );
//Route::get( 'admin/dashboard', 'Admin\AdminController@dashboard' );

/********************** Ajax Routes ********************************/
Route::post( 'ajax/application/s', 'Ajax\AjaxFrontController@saveApplication' );
// save learning goal
Route::post( 'ajax/admin/savelg', 'Ajax\Admin\AjaxLearningGoalController@saveLearningGoal' );
// delete learning goals
Route::post( 'ajax/admin/lg/d', 'Ajax\Admin\AjaxLearningGoalController@deleteLearningGoal' );
// get all learning goals
Route::get( 'ajax/admin/lg/get', 'Ajax\Admin\AjaxLearningGoalController@getLearningGoals' );

// get all placement exam questionaires
Route::get( 'ajax/admin/pe/get', 'Ajax\Admin\AjaxPlacementExamController@getQuestions' );
Route::post( 'ajax/admin/pe/sq', 'Ajax\Admin\AjaxPlacementExamController@saveQuestion' );








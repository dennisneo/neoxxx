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


Route::post( 'ajax/application/s', 'Ajax\AjaxFrontController@saveApplication' );


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

$first_segment  = \Request::segment( 1 );
$second_segment = \Request::segment( 2 );
$third_segment  = \Request::segment( 3 );

/***
$arr = str_split( '59937c6a61cd128a07f25c92ecf9e972' );
dd( collect( $arr )->every( 6 ) );
 ***/

/************** Admin *************************/
if( Request::segment(1) == 'admin' ){
    require_once( __DIR__."/Routes/routes_admin.php" );
    return;
}

if( Request::segment(1) == 'teacher' ){
    require_once( __DIR__."/Routes/routes_teacher.php" );
    return;
}

if( Request::segment(1) == 'student' ){
    require_once( __DIR__."/Routes/routes_student.php" );
    return;
}

if( Request::segment(1) == 'ajax' ){
    require_once( __DIR__."/Routes/routes_ajax.php" );
    return;
}

Route::any( 'login', 'FrontController@login' );
Route::get( 'logout', 'FrontController@logout' );

Route::get( 'application/success', 'FrontController@applicationSuccess' );
Route::get( 'teacher', 'FrontController@applicantLandingPage' );
Route::post( 'landing', 'FrontController@applicantLandingPage' );
Route::get( 'apply', 'FrontController@apply' );

Route::any( 's/application', 'FrontController@studentLandingPage' );
Route::any( 's/application/success', 'FrontController@studentSuccess' );
Route::any( 's/confirm', 'FrontController@studentConfirm' );


if( Request::segment(1) == 'test' ){
    Route::get( 'test/mail', 'TestController@testMail' );
    return;
}

Route::get( 'pwd', 'UtilsController@pwd' );




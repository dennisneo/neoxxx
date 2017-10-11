<?php

Route::get( '/',  function(){
  return redirect( 'login' );
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

if( Request::segment(1) == 'finance' ){
    require_once( __DIR__."/Routes/routes_finance.php" );
    return;
}


if( Request::segment(1) == 'ajax' ){
    // check if called through ajax
    Route::group( [ 'middleware'=>'ajax' ], function(){
        require_once( __DIR__."/Routes/routes_ajax.php" );
        return;
    });

}

Route::any( 'login', 'FrontController@login' );
Route::get( 'logout', 'FrontController@logout' );

Route::get( 'application/success', 'FrontController@applicationSuccess' );
Route::get( 'teacher', 'FrontController@applicantLandingPage' );
Route::post( 'landing', 'FrontController@applicantLandingPage' );
Route::get( 'apply', 'FrontController@apply' );

if( in_array( Request::segment(1) , [ 's', 'student' ]  ) ){
    Route::any( 's/application', 'FrontController@studentLandingPage' );
    Route::any( 'student/application/success', 'FrontController@studentSuccess' );
    Route::any( 's/application/success', 'FrontController@studentSuccess' );
    Route::any( 's/confirm', 'FrontController@studentConfirm' );
}


/***** Alipay specific notifications ********/
if( Request::segment(1) == 'alipay' ){
    Route::any( 'alipay/notice', 'AlipayFrontendController@notify' );
    Route::any( 'alipay/notify/{cost_id}/{user_id}/{skey}', 'AlipayFrontendController@notify' );
    Route::any( 'alipay/return/{cost_id}', 'AlipayFrontendController@ret' );
}

if( Request::segment(1) == 'test' ){
    Route::get( 'test/mail', 'TestController@testMail' );
    return;
}

if( Request::segment(1) == 'cron' ){
    //Route::get( 'cron/compute_salary', 'CronController@computeSalary' );
    Route::get( 'cron/process_day_salary', 'CronController@processDayIncome' );
    Route::get( 'cron/process_range_salary', 'CronController@processRangeIncome' );
}

if( Request::segment(1) == 'utils' ){

    Route::get( 'utils/pq', 'UtilsController@populateQuestions' );
    Route::get( 'utils/alipay', 'UtilsController@alipayBitmash' );
    // email template
    Route::get( 'utils/et/{email_view}', 'UtilsController@viewEmailTemplate' );

    Route::get( 'utils/t', 'UtilsController@teacherSched' );
    Route::get( 'utils/to', 'UtilsController@timeoffset' );
    Route::get( 'utils/ms', 'UtilsController@messageSettings' );
    return;
}

Route::get( 'pwd', 'UtilsController@pwd' );
Route::get( 'download/cv/{application_id}' , 'Common\CommonController@downloadCv' )->middleware(['auth']);





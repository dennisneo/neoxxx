<?php


Route::group( [ 'prefix' => 'finance' , 'as'=> 'finance' , 'middleware' =>[ 'auth.finance' ] ] ,function(){

    Route::get( 'dashboard', 'Finance\FinanceDashboardController@index' );
    Route::get( 'payments', 'Finance\FinanceController@payments' );
    Route::get( 'salary', 'Finance\FinanceController@salary' );

});



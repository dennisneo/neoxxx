<?php

/********************** Ajax Routes ********************************/

Route::group( ['middleware'=>'auth', 'namespace'=>'Ajax\Student', 'prefix' => 'ajax/student', 'as'=> 'ajax.student' ],  function(){
    Route::post('ss',  'AjaxStudentController@saveClassSession');
});


Route::post( 'ajax/application/s', 'Ajax\AjaxFrontController@saveApplication' );
// update applicant status
Route::post( 'ajax/admin/a/us', 'Ajax\Admin\AjaxApplicantsController@updateStatus' );

// save learning goal
Route::post( 'ajax/admin/savelg', 'Ajax\Admin\AjaxLearningGoalController@saveLearningGoal' );
// delete learning goals
Route::post( 'ajax/admin/lg/d', 'Ajax\Admin\AjaxLearningGoalController@deleteLearningGoal' );
// get all learning goals
Route::get( 'ajax/admin/lg/get', 'Ajax\Admin\AjaxLearningGoalController@getLearningGoals' );
Route::get( 'ajax/admin/a/get', 'Ajax\Admin\AjaxApplicantsController@getApplicants' );

// get all placement exam questionaires
Route::get( 'ajax/admin/pe/get', 'Ajax\Admin\AjaxPlacementExamController@getQuestions' );
Route::post( 'ajax/admin/pe/sq', 'Ajax\Admin\AjaxPlacementExamController@saveQuestion' );








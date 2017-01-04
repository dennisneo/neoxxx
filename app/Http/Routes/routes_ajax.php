<?php

    /*************** Ajax Routes **************/

Route::group( [  'prefix' => 'ajax/front' ],  function(){
    // save new student
    Route::post( 'sns',  'Ajax\AjaxFrontController@saveNewStudent');
});

Route::group( ['prefix' => 'ajax/finance', 'middleware'=>['auth.finance'], 'namespace'=>'Ajax\Finance',  'as'=> 'ajax.finance' ],  function(){
    Route::get('getpayments',  'AjaxFinanceController@getPayments');
});

Route::group( ['prefix' => 'ajax/student', 'middleware'=>'auth', 'namespace'=>'Ajax\Student',  'as'=> 'ajax.student' ],  function(){
    // get student incoming schedule
    Route::get( 'ics',  'AjaxStudentController@getIncomingSchedules' );
    // book class in teacher availability view
    Route::post( 'bcta',  'AjaxStudentController@bookClass' );
    // get student placement exam
    Route::get('per',  'AjaxStudentController@getPlacementExam');
    // save student profile
    Route::post( 'sp',  'AjaxStudentController@saveProfile' );
    // get a student
    Route::get('gs',  'AjaxStudentController@getStudent');
    // student setup a class session
    Route::post('ss',  'AjaxStudentController@setupClassSession');
    Route::post('scancel',  'AjaxStudentController@cancelClassSession');

    // find available teachers given a class session
    Route::get('at',  'AjaxStudentController@availableTeachers');
    // teacher selected
    Route::post('ts',  'AjaxStudentController@teacherSelected' );
    // save the session
    Route::post('sas',  'AjaxStudentController@saveClassSession' );
    // save feedback
    Route::post('sf',  'AjaxStudentController@saveFeedback' );

    Route::get('glg',  'AjaxStudentController@getLearningGoals' );
    // save learning goal
    Route::post('slg',  'AjaxStudentController@saveLearningGoals' );

    // get feedback
    Route::get('gf',  'AjaxStudentController@getFeedback' );
    // cancel the session
    Route::post('cs',  'AjaxStudentController@cancelClassSession' );
    // get the credits amount of the student
    Route::get( 'credits',  'AjaxStudentController@getStudentCredits' );
    // get student class sessions
    Route::get( 'gss',  'AjaxStudentController@getStudentSessions' );
    // get the schedule of a teacher
    Route::get('teacher/sessions',  'AjaxStudentController@getTeacherSchedule');
    Route::get('teacher/search',  'AjaxStudentController@searchTeachers');

    /***** placement exam routes ****/
    Route::get( 'pe/gpeq',  'AjaxStudentExamController@getQuestions' );
    Route::post( 'pe/sa',  'AjaxStudentExamController@submitAnswer' );
    // buy credits
    Route::post( 'bc',  'AjaxStudentCreditsController@buy' );
});

Route::group( [ 'prefix' => 'ajax/admin', 'middleware'=>'auth.admin', 'namespace'=>'Ajax\Admin' ],  function(){

    // student chart data
    Route::get( 'dashboard/scd',  'AjaxDashboardController@chartData' );

    // get credits cost in settings
    Route::get( 'settings/credits_cost',  'AjaxSettingsController@getCreditCostAll' );
    Route::post( 'credits_cost/save',  'AjaxSettingsController@saveCreditsCost' );
    Route::post( 'credits_cost/delete',  'AjaxSettingsController@deleteCreditsCost' );
    Route::get( 'credits_cost/get',  'AjaxSettingsController@getCreditCost' );
    Route::post( 'custom_messages/save',  'AjaxSettingsController@saveCustomMessages' );

    // save applicant requirements
    Route::post( 'a/srq',  'AjaxApplicantsController@saveRequirements' );
    // save student note
    Route::post( 'sn',  'AjaxStudentsController@saveNote');
    Route::post( 'dashboard/latest_applicants',  'AjaxDashboardController@latestApplicants' );
    Route::get( 'dashboard/latest_applicants',  'AjaxDashboardController@latestApplicants' );
    Route::get( 'dashboard/latest_students',  'AjaxDashboardController@latestStudents' );

    Route::post( 'teacher/add_schedule',  'AjaxTeachersController@addSchedule' );

});

Route::group( [ 'prefix' => 'ajax/teacher', 'middleware'=>'auth', 'namespace'=>'Ajax\Teacher' ],  function(){
        // get teacher feedbacks
        Route::get( 'feedbacks',  'AjaxTeacherController@getTeacherFeedbacks' );
        //
        Route::post('saveSettings',  'AjaxTeacherController@saveSettings');
        // upcoming classes
        Route::get( 'upcoming',  'AjaxTeacherController@getUpcomingClass' );
        // get class record
        Route::get( 'gcr',  'AjaxTeacherController@getClassRecord' );
        //get teacher schedule
        Route::any( 'gts',  'AjaxTeacherController@getTeacherSchedule' );
        //update class record
        Route::post( 'ucr',  'AjaxTeacherController@updateClassRecord' );
        //delete audio file
        Route::post( 'daf',  'AjaxTeacherController@deleteAudioFile' );
        //upload Audio
        Route::post( 'ua',  'AjaxTeacherController@uploadAudio' );
        // save performance record
        Route::post( 'spr',  'AjaxTeacherController@savePerformanceRecord' );
        // get performance record
        Route::get( 'gpr',  'AjaxTeacherController@getPerformanceRecord' );
        // save profile
        Route::post( 'sp',  'AjaxTeacherController@saveProfile' );
        //upload profile photo
        Route::post( 'upp',  'AjaxTeacherController@uploadProfilePhoto' );
        //update about
        Route::post( 'uab',  'AjaxTeacherController@updateAbout' );
        //upload voice
        Route::post( 'uv',  'AjaxTeacherController@uploadVoice' );
        //upload voice
        Route::post( 'dv',  'AjaxTeacherController@deleteVoice' );

    });

Route::group( [ 'prefix' => 'ajax/teachers', 'middleware'=>'auth', 'namespace'=>'Ajax\Admin',  'as'=> 'ajax.teachers' ],  function(){
    //get all teachers base on query
    Route::get('getall',  'AjaxTeachersController@getTeachers');
    // get teachers for autocomplete
    // will return value and name only
    Route::get('gta',  'AjaxTeachersController@getTeachersForAutocomplete');
    //

});

Route::group( [ 'prefix' => 'ajax/teacher', 'middleware'=>'auth', 'namespace'=>'Ajax\Teacher',  'as'=> 'ajax.teachers' ],  function(){
    Route::post( 'save',  'AjaxTeachersController@saveTeacher' );
    Route::get( 'performance',  'AjaxTeacherController@getPerformanceRecord' );
});

Route::group( [  'prefix' => 'ajax/students', 'middleware'=>'auth', 'namespace'=>'Ajax\Admin', 'as'=> 'ajax.students' ],  function(){
    Route::get('getall',  'AjaxStudentsController@getStudents');
    Route::get('getAvailableTeachers',  'AjaxStudentsController@getAvailableTeachers');
});

Route::get( 'ajax/student/settings/credits_cost',  'Ajax\Admin\AjaxSettingsController@getCreditCostAll' );
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

// get schedules
Route::get( 'ajax/admin/gsched',  'Ajax\Admin\AjaxSchedulesController@getSchedules' );

Route::get( 'ajax/admin/sinfo',  'Ajax\Admin\AjaxStudentsController@getStudentInfo' );

// get all placement exam questionaires
Route::get( 'ajax/admin/pe/get', 'Ajax\Admin\AjaxPlacementExamController@getQuestions' );
Route::post( 'ajax/admin/pe/sq', 'Ajax\Admin\AjaxPlacementExamController@saveQuestion' );

Route::post( 'ajax/admin/settings/s', 'Ajax\Admin\AjaxSettingsController@saveSettings' );

Route::post( 'ajax/note/save', 'Ajax\AjaxCommonController@saveNote' );
Route::get( 'ajax/notes/get', 'Ajax\AjaxCommonController@getNotes' );

Route::get( 'ajax/req/get', 'Ajax\AjaxCommonController@getApplicantRequirements' );

Route::get( 'ajax/admin/teacher/get_schedule',  'Ajax\Admin\AjaxTeachersController@getSchedule' );

//get time select for teacher availability
Route::get( 'ajax/util/ts', 'Ajax\AjaxUtilsController@timeSelect' );









<?php

    /*************** Ajax Routes **************/

Route::group( [  'prefix' => 'ajax/front' ],  function(){
    // save new student
    Route::post( 'sns',  'Ajax\AjaxFrontController@saveNewStudent');
});

Route::group( ['prefix' => 'ajax/student', 'middleware'=>'auth', 'namespace'=>'Ajax\Student',  'as'=> 'ajax.student' ],  function(){
        // student setup a class session
    Route::post('ss',  'AjaxStudentController@setupClassSession');
    // find available teachers given a class session
    Route::get('at',  'AjaxStudentController@availableTeachers');
    // teacher selected
    Route::post('ts',  'AjaxStudentController@teacherSelected' );
    // save the session
    Route::post('sas',  'AjaxStudentController@saveClassSession' );
    // save feedback
    Route::post('sf',  'AjaxStudentController@saveFeedback' );
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
});

Route::group( [ 'prefix' => 'ajax/admin', 'middleware'=>'auth.admin', 'namespace'=>'Ajax\Admin' ],  function(){

    Route::get( 'dashboard/latest_applicants',  'AjaxDashboardController@latestApplicants' );
    Route::get( 'dashboard/latest_students',  'AjaxDashboardController@latestStudents' );
    Route::post( 'teacher/add_schedule',  'AjaxTeachersController@addSchedule' );
    Route::get( 'teacher/get_schedule',  'AjaxTeachersController@getSchedule' );
});


Route::group( [ 'prefix' => 'ajax/teacher', 'middleware'=>'auth', 'namespace'=>'Ajax\Teacher' ],  function(){
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
    });


    Route::group( [ 'prefix' => 'ajax/teachers', 'middleware'=>'auth', 'namespace'=>'Ajax\Admin',  'as'=> 'ajax.teachers' ],  function(){
        //get all teachers base on query
        Route::get('getall',  'AjaxTeachersController@getTeachers');
        // get teachers for autocomplete
        // will return value and name only
        Route::get('gta',  'AjaxTeachersController@getTeachersForAutocomplete');
    });

    Route::group( [ 'prefix' => 'ajax/teacher', 'middleware'=>'auth', 'namespace'=>'Ajax\Admin',  'as'=> 'ajax.teachers' ],  function(){
        Route::post( 'save',  'AjaxTeachersController@saveTeacher' );
    });

    Route::group( [  'prefix' => 'ajax/students', 'middleware'=>'auth', 'namespace'=>'Ajax\Admin', 'as'=> 'ajax.students' ],  function(){
        Route::get('getall',  'AjaxStudentsController@getStudents');
        Route::get('getAvailableTeachers',  'AjaxStudentsController@getAvailableTeachers');
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

    Route::post( 'ajax/admin/settings/s', 'Ajax\Admin\AjaxSettingsController@saveSettings' );









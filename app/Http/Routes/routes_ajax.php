<?php

    /*************** Ajax Routes **************/

    Route::group( ['middleware'=>'auth', 'namespace'=>'Ajax\Student', 'prefix' => 'ajax/student', 'as'=> 'ajax.student' ],  function(){
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

    Route::group( ['middleware'=>'auth', 'namespace'=>'Ajax\Admin', 'prefix' => 'ajax/teachers', 'as'=> 'ajax.teachers' ],  function(){
        Route::get('getall',  'AjaxTeachersController@getTeachers');
    });

    Route::group( ['middleware'=>'auth', 'namespace'=>'Ajax\Admin', 'prefix' => 'ajax/teacher', 'as'=> 'ajax.teachers' ],  function(){
        Route::post('save',  'AjaxTeachersController@saveTeacher');
    });

    Route::group( ['middleware'=>'auth', 'namespace'=>'Ajax\Admin', 'prefix' => 'ajax/students', 'as'=> 'ajax.students' ],  function(){
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









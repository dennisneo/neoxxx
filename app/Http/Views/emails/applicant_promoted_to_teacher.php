<?php

    $message =  App\Models\Settings\Settings::getByKey( 'message_applicant_promoted' );
    $settings = new \App\Models\Settings\Settings;

    $merge_array =[
       '{user_first_name}' => $user->first_name,
       '{user_last_name}' => $user->last_name
    ];

    echo $settings->merge( $message , $merge_array );



<?php


     view()->addLocation( app_path().'/Http/Views/themes/agency/layouts' );
     echo view( 'agency_default' , [ 'content' => 'Page not found' ] )->render();

<div>
    Hi <?php echo $teacher->first_name ?>,
    <?php $time =  strtotime( \Helpers\DateTimeHelper::serverTimeToTimezone( $class_session->schedule_start_at , $teacher->timezone ) ); ?>
    <br /><br  />
    A new class session was assigned to you with details below: <br />
    Date :  <?php echo date( 'M d, Y' , $time ) ?><br />
    Time :  <?php echo date( 'H:i a' ,  $time ); ?><br />
    Duration : <?php echo $class_session->duration ?> mins
    <br /><br />
    You may view the details on your <?php echo env('COMPANY_NAME')  ?> account. Please be ready at least 30 minutes before the class starts.
    <br /><br />
    
    <?php echo env('COMPANY_NAME') ?>
</div>


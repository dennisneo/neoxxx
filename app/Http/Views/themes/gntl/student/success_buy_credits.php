<div id="bDiv" class="x_panel tile" style="min-height:280px;" >
    <div class="x_content">
        <br />
        <div style="font-size: 14px">
        <b>You have successfully purchased <?php echo $c->credits ?> credits.</b><br />
        <br />You may now choose your teacher and start learning English.
        <br />Please wait while we redirect you to the dashboard
        in <b><span id="cd"></span></b> seconds;

        </div>
        <br /><br />
        <a href="<?php echo Url( 'student/dashboard') ?>" class="btn btn-success"> Go to Dashboard Now </a>
    </div>
</div>

<script>
    $(document).ready(
        function(){
            countdown();
        }
    );

    let s = 10;
    function countdown()
    {
        setTimeout( function(){
            s = s - 1 ;
            $('#cd').html( s );
            if( s > 1 ){
                countdown();
            }else{
                location.href=subdir+'/student/dashboard';
            }
        }, 1000 );
    }
</script>
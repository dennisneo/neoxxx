<div id="sDiv">
    <?php if( ! $r->user()->confirmed ){ ?>
    <div class="alert alert-danger" style="margin-top: 64px ">
        <b>
        You have not validated your account yet. Please check your email for the confirmation link.
        In case you want to resend the confirmation email <a href="javascript:" @click="sendConfirmationEmail" style="color:yellow"> click here </a>
        </b>
    </div>
    <?php } ?>
<div class="row">
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="x_panel tile"  style="height:180px">
            <div class="x_title">
                <h2><i class="fa fa-calendar blue" ></i> <?php echo trans('general.book_a_class') ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h2>Schedule a class and choose your teacher</h2>
                <div class="col-lg-6 col-lg-offset-3">
                    <button class="btn btn-lg btn-success" v-on:click="bookClass"><i class="fa fa-calendar white" ></i> <?php echo trans('general.book_a_class') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="x_panel tile" style="height:180px;" >
            <div class="x_title">
                <h2><i class="fa fa-money green"></i> Wallet</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <h2> You got <b>{{credits}}</b> credits in your wallet</h2>
                    <div class="col-lg-6 col-lg-offset-3">
                        <a href="<?php echo url('student/credits/buy') ?>" class="btn btn-warning btn-lg"> <i class="fa fa-plus"></i> Add More Credits </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


</div>


<?php echo \App\Http\Controllers\Student\StudentPartialsController::classSchedulePartial( $r ) ?>


<?php echo \App\Http\Controllers\Student\StudentPartialsController::findTeachersPartial( $r ) ?>

<?php echo \App\Http\Controllers\Student\StudentPartialsController::placementExamPartial( $r ) ?>

<?php echo \App\Http\Controllers\Student\StudentPartialsController::bookClassPartial( $r ) ?>


<script>

</script>
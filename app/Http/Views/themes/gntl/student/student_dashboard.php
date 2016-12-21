<div id="sDiv">

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
                        <a href="<?php echo url('student/credits/buy') ?>" class="btn btn-warning btn-lg"> Add More Credits </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel tile"  style="">
                <div class="x_title">
                    <h3><b><?php echo trans('general.upcoming_class_schedule') ?></b></h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-striped">
                        <tr>
                            <th></th>
                            <th>Session ID</th>
                            <th>Teacher</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                        <tr v-bind:class="sessions.length > 0 ? 'hide' : '' " >
                            <td colspan="4"> No incoming schedule found </td>
                        </tr>
                        <tr v-bind:class="sessions.length > 0 ? 'hide' : '' " >
                            <td colspan="4"></td>
                        </tr>
                        <tr v-for="s in sessions">
                            <td></td>
                            <td>{{s.cid}}</td>
                            <td>{{s.teacher_short_name}}</td>
                            <td>{{s.day}}</td>
                            <td>{{s.time}}</td>
                            <td>{{s.class_status}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo \App\Http\Controllers\Student\StudentPartialsController::findTeachersPartial( $r ) ?>

<?php echo \App\Http\Controllers\Student\StudentPartialsController::placementExamPartial( $r ) ?>

<?php echo \App\Http\Controllers\Student\StudentPartialsController::bookClassPartial( $r ) ?>


<script>

</script>
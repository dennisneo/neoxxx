<div id="sDiv">
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="x_panel tile"  style="min-height:280px">
            <div class="x_title">
                <h2>Schedule a Class</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="sForm">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for=""><?php echo trans('general.date') ?> </label>
                            <div class="input-group">
                                <?php echo \Form::text( 'date' , date('Y-m-d') , [ 'class' => 'form-control' , 'id'=>'date' ] ) ?>
                                <span class="input-group-addon" id="basic-addon2">
                        <a href="javascript:" v-on:click="showCalendar"><i class="fa fa-calendar"></i></a>
                    </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-6" >
                            <label for="time"><?php echo trans( 'general.preferred_start_time' ) ?></label><br />
                            <input type="text" id="time" data-format="h:mm a" data-template="hh : mm a" name="time">
                            <!--<input id="datetime12" data-format="DD-MM-YYYY h:mm a" data-template="hh : mm a" name="datetime" value="8:30 pm" type="text">-->
                            <?php //echo Helpers\DateTimeHelper::timeDropdown() ?>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label for="duration"><?php echo trans('general.duration') ?> </label>
                            <?php echo \Form::select( 'duration' , [ 30 => '30 min' , 60 => '1 hr' ],'' , [ 'class' => 'form-control' , 'id'=>'duration' ] ) ?>
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="dn"> <span style="color:white">.</span> </label>
                            <a href="javascript:" id="next" class="form-control btn btn-success btn-md" v-on:click="scheduleSession"> Next </a>
                        </div>
                    </div>
                    <?php echo csrf_field() ?>
                    <input type="hidden" name="student_id" id="student_id" value="<?php echo \App\Models\Users\UserEntity::me()->id ?>" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="x_panel tile" style="min-height:280px;" >
            <div class="x_title">
                <h2>Wallet</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <h2> You got <b>{{credits}}</b> credits in your wallet</h2>
                    <div class="col-lg-6 col-lg-offset-3">
                        <br />
                        <a href="<?php echo url('student/credits/buy') ?>" class="btn btn-warning btn-lg"> Add More Credits </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

    <div class="row">
        <div class="x_panel tile">
            <div class="x_title">
                <h2>Getting Started</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="x_panel tile">
            <div class="x_title">
                <h2>Upcoming Classes</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="x_panel tile">
            <div class="x_title">
                <h2>Past Classes</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#time').combodate(
            {
                customClass: 'date-control'
            }
        );

    });
</script>
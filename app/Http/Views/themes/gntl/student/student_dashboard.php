<div id="sDiv">
<div class="col-lg-6">
    <div class="x_panel tile fixed_height_320">
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
                <input id="datetime12" data-format="DD-MM-YYYY h:mm a" data-template="hh : mm a" name="datetime" value="21-12-2012 8:30 pm" type="text">
            </div>
            </div>
            <div class="row">

            </div>
            <div class="row">
                <div class="form-group col-lg-4">
                    <label for="duration"><?php echo trans('general.duration') ?> </label>
                    <?php echo \Form::select( 'duration' , [ 30 => '30 min' , 60 => '1 hr' ],'' , [ 'class' => 'form-control' , 'id'=>'duration' ] ) ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-4">
                    <br />
                <a href="javascript:" id="next" class="btn btn-success btn-lg" v-on:click="scheduleSession"> Next </a>
                </div>
            </div>
            <?php echo csrf_field() ?>
            </form>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="x_panel tile fixed_height_320">
        <div class="x_title">
            <h2>Credits</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <h4> Current credits on your wallet: </h4>
            <div class="col-lg-6 col-lg-offset-3">
                <br /><br />
                <button class="btn btn-warning btn-lg"> Add More Credits </button>
            </div>
        </div>

    </div>
</div>
</div>

<script>
    $(function(){
        $('#datetime12').combodate(
            {
                customClass: 'date-control'
            }
        );


    });
</script>
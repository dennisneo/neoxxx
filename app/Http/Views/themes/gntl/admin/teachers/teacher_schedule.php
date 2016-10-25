
<div id="tsDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">

                <div>
                    <div class="row" style="">
                        <div class="col-lg-1">
                            <img src="<?php echo $t->profile_photo_url ?>"  class="img-responsive" />
                        </div>
                        <div class="col-lg-11" style="vertical-align:top;padding:0;margin:0">
                            <div class="pull-right">
                                <button class="btn btn-success" v-on:click="openNewSched()"> <i class="fa fa-plus"></i> <b>Add Schedule</b></button>
                            </div>
                            <h3><b><?php echo $t->last_name.', '.$t->first_name ?></b></h3>
                            <?php echo  $t->location ?>
                        </div>
                    </div>

                </div>

                <br /><br />
                <div id='calendar'></div>

            </div>
        </div>
    </div>

    <div id="schedModal" class="modal fade">
        <div class="modal-dialog">
            <form id="tForm">
            <input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo \Helpers\Text::convertInt( $t->id ) ?>" />
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="start_time">Start Time</label>
                                <input type="text" id="start_time" data-format="h:mm a" value="8:00 am" data-template="hh : mm a" name="start_time">

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="end_time">End Time</label>
                                <input type="text" id="end_time" data-format="h:mm a" value="11:00 am" data-template="hh : mm a" name="end_time">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <b> Day of the Week: </b>
                            <div>
                            <?php foreach ( \Helpers\DateTimeHelper::daysOfTheWeek() as $k => $v ) { ?>
                                <input type="checkbox" class="dow" name="dow[]" value="<?php echo $k ?>" /> <?php echo  $v ?> &nbsp;&nbsp;&nbsp;
                            <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="javascript:" type="button" class="btn btn-primary" v-on:click="saveSched()">Save Schedule</a>
                </div>
                <?php echo csrf_field() ?>

            </div>
            </form>
        </div>
    </div>

    <div id="eventModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>


<input type="hidden" name="date_today" id="date_today" value="<?php echo date('Y-m-d'); ?>" />
<div id="csDiv" class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile"  style="">
        <div class="x_title">
            <div class="pull-right">
                <button class="btn btn-default" @click="openStudentScheduleModal"><i class="fa fa-calendar"></i> Calendar </button>

            </div>
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
                    <th></th>
                </tr>
                <tr v-bind:class="sessions.length > 0 ? 'hide' : '' " >
                    <td colspan="7"> No incoming schedule found </td>
                </tr>
                <tr v-bind:class="sessions.length > 0 ? 'hide' : '' " >
                    <td colspan="7"></td>
                </tr>
                <tr v-for="s in sessions">
                    <td></td>
                    <td>{{s.cid}}</td>
                    <td>{{s.teacher_short_name}}</td>
                    <td>{{s.day}}</td>
                    <td>{{s.time}}</td>
                    <td>{{s.class_status}}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" v-show="showConfirmButton(s)" @click="confirmClass(s)"> <i class="fa fa-check"></i> Confirm</button>
                        <button class="btn btn-default btn-sm" v-show="showCancelButton(s)" @click="cancelClass(s)">Cancel</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

    <div id="schedModal" class="modal fade">
        <div class="modal-dialog" style="width: 96%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo trans('general.my_class_schedule') ?> </h4>
                </div>
                <div class="modal-body" id="sched_calendar">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>
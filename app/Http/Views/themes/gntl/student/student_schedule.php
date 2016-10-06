<div id="ssDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <h3><b>Class Schedules</b></h3>
                <br />
                <table class="table table-striped">
                    <tr>
                        <th></th>
                        <th>Teacher</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    <tr v-bind:class="sessions.length > 0 ? 'hide' : '' " >
                        <td colspan="5"><span class="loading"><i class="fa fa-spin fa-refresh"></i></span></td>
                    </tr>
                    <tr v-bind:class="sessions.length > 0 ? 'hide' : '' " >
                        <td colspan="5"></td>
                    </tr>
                    <tr v-for="s in sessions">
                        <td></td>
                        <td>{{s.teacher_short_name}}</td>
                        <td>{{s.day}} {{s.time}}</td>
                        <td>{{s.status}}</td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


</div>
<input type="hidden" name="student_id" id="student_id" value="<?php echo \App\Models\Users\UserEntity::me()->id ?>" />

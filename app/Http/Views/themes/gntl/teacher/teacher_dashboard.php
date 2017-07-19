<div id="tDiv" style="" class="v-cloak">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <h3><b>My Dashboard</b></h3>
                <br /><br />
                <div class="col-lg-6">
                    <div class="x_panel tile" style="height: 320px">
                        <div class="x_header">
                            <h4><b>Upcoming Schedule</b></h4>
                        </div>
                        <div class="x_content">
                            <!--
                            <ul class="list-group">
                                <li class="list-group-item" @class="notifications.length ? 'hide' : '' ">  <?php echo trans( 'general.no_schedule_found' ); ?></li>
                                <li class="list-group-item" v-for="n in classes">
                                </li>
                            </ul>
                            -->
                            <table class="table table-striped">
                                <tr v-for="n in classes" style="cursor: pointer" @click="openClassRecord( n.class_id )">
                                    <td>{{n.day}} {{n.time}}</td>
                                    <td>{{n.student_short_name}}</td>
                                </tr>
                                <tr v-show="!classes.length">
                                    <td> No upcoming class</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <input type="hidden" name="tid" id="tid" value="<?php echo \Helpers\Text::convertInt( $t->id ) ?>" />
                </div>
                <div class="col-lg-6">
                    <div class="x_panel tile" style="height: 320px">
                        <div class="x_header">
                            <h4><b><?php echo trans('general.notifications') ?> </b></h4>
                        </div>
                        <div class="x_content">
                            <ul class="list-group">
                                <li class="list-group-item" @class="notifications.length ? 'hide' : '' "> No notification found</li>
                                <li class="list-group-item" v-for="n in notifications | orderBy 'timestamp' -1 ">

                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--
                    <div class="x_panel tile" style="height: 320px">
                        <div class="x_header">
                            <div class="pull-right">
                                <a href="<?php echo Url('teacher/profile') ?>" class="btn btn-success btn-sm">Profile Page </a>
                            </div>
                            <h4><b>My Profile</b></h4>
                        </div>
                        <div class="x_content">
                            <div class="col-lg-6">
                                <img src="<?php echo $t->profilePhotoUrl() ?>" class="img-responsive"/>
                                <br />

                            </div>
                            <div class="col-lg-6">
                                <b><?php echo $t->first_name.' '.$t->last_name ?></b>
                                <div><?php echo $t->city.' '.$t->country ?> <?php echo $t->timezone > 0 ? '+'.$t->timezone : $t->timezone ?></div>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="x_panel tile" style="">
                        <div class="x_header">
                            <div class="pull-right">
                                <button class="btn btn-primary" @click="openRequest"> Request Schedule Change</button>
                            </div>
                            <h4><b>Class Hours</b></h4>
                        </div>
                        <div class="x_content">

                                <div class="alert alert-success" style="background-color:#dfe9fe">
                                   <span style="color:#333333"> Please note: These are the hours you are required to be available to your students </span>
                                </div>

                            <table class="table table-striped">
                                <tr v-for="h in wh">
                                    <td>
                                        {{h[0].weekday}}
                                    </td>
                                    <td>
                                        <span v-for="hh in h">
                                            {{ hh.readable_start_time }} - {{ hh.readable_end_time }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div id="requestModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Message to Admin</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea name="message" style="width:100%;height:120px"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    </div>
    <div id="profileModal" class="modal fade">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>


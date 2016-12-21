<div id="tDiv" style="">
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
                            <table class="table table-striped">
                                <tr>
                                    <th> Student </th>
                                    <th> Start Time </th>
                                    <th> Duration </th>
                                </tr>
                                <tr>
                                    <td colspan="3" :class="classes.length ? 'hide' : '' ">
                                        <?php echo trans( 'general.no_schedule_found' ); ?>
                                    </td>
                                </tr>
                                <tr v-for="c in classes">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="tid" id="tid" value="<?php echo $t->id ?>" />
                </div>
                <div class="col-lg-6">
                    <div class="x_panel tile" style="height: 320px">
                        <div class="x_header">
                            <h4><b><?php echo trans('general.notifications') ?> </b></h4>
                        </div>
                        <div class="x_content">

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
                    <p>Body</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>


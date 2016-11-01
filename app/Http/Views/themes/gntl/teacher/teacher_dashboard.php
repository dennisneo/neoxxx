<div id="tDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <h3><b>My Dashboard</b></h3>
                <br /><br />
                <div class="col-lg-6">
                    <div class="x_panel tile">
                        <div class="x_header">
                            <h4><b>Today's Schedule</b></h4>
                        </div>
                        <div class="x_content">

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="x_panel tile">
                        <div class="x_header">
                            <div class="pull-right">
                                <!--<a href="javascript:"><i class="fa fa-edit"></i> Edit </a>-->
                                <button class="btn btn-success btn-sm" v-on:click="editProfile()" >Edit</button>
                            </div>

                        </div>
                        <div class="x_content">
                            <div class="col-lg-6">
                                <img src="<?php echo Url('public/images/blank_face.png') ?>" class="img-responsive"/>
                                <br />
                                <div style="text-align: center">
                                    <button class="btn btn-success btn-sm">Update Profile Photo</button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <b><?php echo $t->first_name.' '.$t->last_name ?></b>
                                <div><?php echo $t->city.' '.$t->country ?> <?php echo $t->timezone > 0 ? '+'.$t->timezone : $t->timezone ?></div>
                            </div>
                        </div>
                    </div>

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


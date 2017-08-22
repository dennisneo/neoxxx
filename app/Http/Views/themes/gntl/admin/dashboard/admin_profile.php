<style>

</style>

<div id="sDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <h3><b>My Profile</b></h3>
                <br />
                <div class="col-lg-6" >
                    <div class="x_panel tile" style="">
                        <div class="x_content">
                            <div class="col-lg-5">
                                <form>
                                    <div>
                                        <img src="<?php //echo $s->profile_photo_url ?>" class="img-responsive" id="photo_src"/>
                                        <div id="progress" style="padding:4px 0 4px 0">
                                            <div class="bar" style="width:0%;background-color:green;display:block;height:12px;">&nbsp;</div>
                                        </div>
                                        <br />
                                        <!--<a href="javascript:" class="btn btn-default" v-on:click="uploadPhoto"> Upload Photo</a>-->
                                        <label class="btn btn-default btn-file">
                                            Upload Photo
                                            <input style="display: none;" id="fileupload" type="file" name="photo" class="file-input" data-url="<?php echo Url('/ajax/teacher/upp') ?>" style="color: transparent;">
                                        </label>
                                        <?php echo csrf_field() ?>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-7">
                                <b><h4><?php echo $me->full_name ?></h4></b>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">

                    <div class="x_panel tile" style="">
                        <div class="x_content">
                            <div style="height: 214px;margin-bottom:24px ">
                                <div class="pull-right">
                                    <button class="btn btn-default" v-on:click="openAboutModal">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>


    <div id="photoModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Upload Profile Photo</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    &nbsp;
                </div>
            </div>
        </div>
    </div>

</div>

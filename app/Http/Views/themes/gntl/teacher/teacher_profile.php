<style>
    table tr td{
        padding: 4px;
        vertical-align: top;
        font-size: 1.2em;
    },

</style>

<div id="tpDiv" style="">
    <div class="x_panel tile" style="height:480px">
        <div class="x_content">
            <div class="row">
                <div class="pull-right">
                    <button class="btn btn-primary" v-on:click="editProfile">
                        <i class="fa fa-pencil"></i> Edit Profile
                    </button>
                </div>

                <h3><b>My Profile</b></h3>
                <br />
                <div class="col-lg-6">
                    <div class="x_panel tile" style="height:384px">
                        <div class="x_content">
                            <div class="col-lg-6" >
                                <form>
                                <div>
                                    <img src="<?php echo $t->profile_photo_url ?>" class="img-responsive" id="photo_src"/>
                                    <div id="progress" style="padding:4px 0 4px 0">
                                        <div class="bar" style="width:0%;background-color:green;display:block;height:12px;">&nbsp;</div>
                                    </div>
                                    <br />
                                    <!--<a href="javascript:" class="btn btn-default" v-on:click="uploadPhoto"> Upload Photo</a>-->
                                    <label class="btn btn-default btn-file">
                                        <i class="fa fa-upload"></i> Upload Photo
                                        <input style="display: none;" id="fileupload" type="file" name="photo" class="file-input" data-url="<?php echo Url('/ajax/teacher/upp') ?>" style="color: transparent;">
                                    </label>
                                    <i class="fa fa-question fa-border" style="cursor: pointer"  @click="openImageInfo"></i>
                                    <?php echo csrf_field() ?>
                                </div>
                                </form>
                            </div>
                            <div class="col-lg-6">
                                <h2><?php echo $t->full_name ?></h2>
                                <?php echo $t->location ?> <?php echo $t->timezone ?>
                                <hr />
                                <table class="">
                                    <tr>
                                        <td>Email : </td>
                                        <td><?php echo $t->email ?></td>
                                    </tr>
                                    <tr>
                                        <td>Skype : </td>
                                        <td><?php echo $t->skype ?></td>
                                    </tr>
                                    <tr>
                                        <td>QQ :</td>
                                        <td><?php echo $t->qq ?></td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6" style="height:420px">
                    <div class="x_panel tile" style="">
                        <div class="x_content">
                            <div style="margin-bottom:24px;">
                                <div class="pull-right">
                                    <button class="btn btn-default" v-on:click="openAboutModal"> <i class="fa fa-pencil"></i> Edit Write-up</button>
                                </div>
                                <h2><b>About</b></h2>
                                <hr />
                                <div id="about" style="overflow-y: scroll;height:144px ">
                                    <?php echo $t->about ? $t->about : 'Nothing written' ?>
                                </div>
                            </div>
                            <div class="pull-right">
                                <form>
                                <?php echo csrf_field() ?>
                                <!--<a href="javascript:" class="btn btn-default" v-on:click="uploadPhoto"> Upload Photo</a>-->
                                <label class="btn btn-default btn-file">
                                    <i class="fa fa-upload"></i>  Upload Voice <br />
                                    <input style="display: none;" id="voiceupload" type="file" name="audio" class="file-input" data-url="<?php echo Url('/ajax/teacher/uv') ?>" style="color: transparent;">
                                </label>
                                    <i class="fa fa-question fa-border" style="cursor: pointer"  @click="openAudioInfo"></i>
                                </form>
                            </div>
                            <h2><b>Voice Recording</b></h2>
                            <hr />
                            <div id="progress" style="padding:4px 0 4px 0">
                                <div class="abar" style="width:0%;background-color:green;display:block;height:12px;">&nbsp;</div>
                                <div class="udiv hide" id="hasAudio">
                                    <div class="pull-right">
                                        <a href="javascript:" class="btn btn-danger" v-on:click="deleteAudio( <?php echo $t->cid  ?>)">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </div>
                                    <audio src="<?php echo $t->voice_url ?>" id="audio_control" controls></audio>
                                </div>
                            </div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="profileModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <form id="pForm">
                <div class="modal-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <h5>First Name *</h5>
                            <?php echo \Form::text( 'first_name' , $t->first_name , [ 'class' => 'form-control' , 'id'=>'first_name' ,  "required" ] ) ?>
                        </div>
                        <div class="form-group">
                            <h5>Last Name *</h5>
                            <?php echo \Form::text( 'last_name' , $t->last_name , [ 'class' => 'form-control' , 'id'=>'last_name' ,  "required" ] ) ?>
                        </div>
                        <div class="form-group">
                            <h5>Middle Name</h5>
                            <?php echo \Form::text( 'middle_name' ,$t->middle_name , [ 'class' => 'form-control' , 'id'=>'middle_name' ] ) ?>
                        </div>

                        <div class="form-group">
                            <h5>Country * </h5>
                            <?php  echo  \App\Http\Models\Locations\Countries::selectList( ['default' => $t->country ] ) ?>
                        </div>

                        <div class="form-group">
                            <h5>City *</h5>
                            <?php echo \Form::text( 'city' , $t->city , [ 'class' => 'form-control' , 'id'=>'city' , 'required' ] ) ?>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <h5>Email *</h5>
                            <?php echo \Form::email( 'email' , $t->email , [ 'class' => 'form-control' , 'id'=>'email' , 'required' ] ) ?>
                        </div>
                        <div class="form-group">
                            <h5>Skype ID *</h5>
                            <?php echo \Form::text( 'skype' , $t->skype , [ 'class' => 'form-control' , 'id'=>'skype' , 'required'] ) ?>
                        </div>
                        <div class="form-group">
                            <h5>Mobile number *</h5>
                            <?php echo \Form::text( 'mobile' , $t->mobile , [ 'class' => 'form-control' , 'id'=>'mobile' , 'required' ] ) ?>
                        </div>
                        <div class="form-group">
                            <h5>Birthday</h5>
                            <div class="form-group">
                                <div id="div-date">
                                    <input type="text" class="form-control" id="date1" data-format="YYYY-MM-DD" data-template="MMM D YYYY" name="birthday" value="<?php echo $t->birthday ?>">
                                </div>
                            </div>
                        </div>
                     </div>
                    <div class="clearfix"></div>
                </div>
                    <?php echo csrf_field() ?>
                    <input type="hidden" name="id" id="id" value="<?php echo $t->id ?>" />
                </form>
                <div class="modal-footer">
                    <button type="button" id="spButton" class="btn btn-primary" v-on:click="saveProfile()">Save</button>
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

    <div id="aboutModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Write something about yourself</h4>
                </div>
                <form id="aForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="about"></label>
                        <?php echo \Form::textarea( 'about' , $t->about , [ 'class' => 'form-control' , 'id'=>'about' , 'style'=>"width:100%" ] ) ?>
                    </div>
                </div>
                <?php echo csrf_field() ?>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" v-on:click="saveAbout" id="abButton">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="audioInfoModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Allowed audio files for upload are mp3,  wav, ogg
                </div>
            </div>
        </div>
    </div>

    <div id="imageInfoModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Allowed images files for upload are png and jpg with max size of 5MB
                </div>
            </div>
        </div>
    </div>

</div>


<?php if( $t->voice_url ){ ?>
<script>
    $('#hasAudio').removeClass( 'hide' )
</script>
<?php } ?>
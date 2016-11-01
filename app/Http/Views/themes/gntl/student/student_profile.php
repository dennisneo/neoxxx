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
                                    <img src="<?php echo $s->profile_photo_url ?>" class="img-responsive" id="photo_src"/>
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
                                <div class="pull-right">
                                    <button class="btn btn-default" v-on:click="openProfileModal">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </div>
                                <h2><?php echo $s->first_name.' '.$s->last_name ?></h2>
                                <?php echo $s->location ?>
                                <hr />
                                <table class="">
                                    <tr>
                                        <td style="width: 72px">Email : </td>
                                        <td> <?php echo $s->email ?></td>
                                    </tr>
                                    <tr>
                                        <td>Skype : </td>
                                        <td> <?php echo $s->skype ?></td>
                                    </tr>
                                    <tr>
                                        <td>QQ :</td>
                                        <td> <?php echo $s->qq ?></td>
                                    </tr>
                                    <tr>
                                        <td>Phone :</td>
                                        <td> <?php echo $s->mobile ?></td>
                                    </tr>
                                </table>
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

                                <h2><b>About Me</b></h2>
                                <hr />
                                <div id="about">
                                    <?php echo $s->about ? $s->about : 'Nothing written' ?>
                                </div>
                            </div>

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
                            <?php echo \Form::text( 'first_name' , $s->first_name , [ 'class' => 'form-control' , 'id'=>'first_name' ,  "required" ] ) ?>
                        </div>
                        <div class="form-group">
                            <h5>Last Name *</h5>
                            <?php echo \Form::text( 'last_name' , $s->last_name , [ 'class' => 'form-control' , 'id'=>'last_name' ,  "required" ] ) ?>
                        </div>
                        <div class="form-group">
                            <h5>Middle Name</h5>
                            <?php echo \Form::text( 'middle_name' ,$s->middle_name , [ 'class' => 'form-control' , 'id'=>'middle_name' ] ) ?>
                        </div>

                        <div class="form-group">
                            <h5>Country * </h5>
                            <?php  echo  \App\Http\Models\Locations\Countries::selectList( ['default' => $s->country ] ) ?>
                        </div>

                        <div class="form-group">
                            <h5>City *</h5>
                            <?php echo \Form::text( 'city' , $s->city , [ 'class' => 'form-control' , 'id'=>'city' , 'required' ] ) ?>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <h5>Email *</h5>
                            <?php echo \Form::email( 'email' , $s->email , [ 'class' => 'form-control' , 'id'=>'email' , 'required' ] ) ?>
                        </div>
                        <div class="form-group">
                            <h5>Skype ID *</h5>
                            <?php echo \Form::text( 'skype' , $s->skype , [ 'class' => 'form-control' , 'id'=>'skype' , 'required'] ) ?>
                        </div>
                        <div class="form-group">
                            <h5>QQ ID* </h5>
                            <?php echo \Form::text( 'qq' , $s->qq , [ 'class' => 'form-control' , 'id'=>'qq' , 'required'] ) ?>
                        </div>
                        <div class="form-group">
                            <h5>Mobile number *</h5>
                            <?php echo \Form::text( 'mobile' , $s->mobile , [ 'class' => 'form-control' , 'id'=>'mobile' , 'required' ] ) ?>
                        </div>
                        <div class="form-group">
                            <h5>Birthday</h5>
                            <div class="form-group">
                                <div id="div-date">
                                    <input type="text" class="form-control" id="date1" data-format="YYYY-MM-DD" data-template="MMM D YYYY" name="birthday" value="<?php echo $s->birthday ?>">
                                </div>
                            </div>
                        </div>
                     </div>
                    <div class="clearfix"></div>
                </div>
                    <?php echo csrf_field() ?>
                    <input type="hidden" name="id" id="id" value="<?php echo $s->id ?>" />
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
                        <?php echo \Form::textarea( 'about' , $s->about , [ 'class' => 'form-control' , 'id'=>'about' , 'style'=>"width:100%" ] ) ?>
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

</div>


<?php if( $s->voice_url ){ ?>
<script>
    $('#hasAudio').removeClass( 'hide' )
</script>
<?php } ?>
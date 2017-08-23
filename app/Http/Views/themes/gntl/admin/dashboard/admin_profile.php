<style>

</style>

<div id="pDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row" >
                <h3><b>My Profile</b></h3>
                <br />
                <div class="col-lg-6 col-xs-12">
                    <div class="x_panel tile" style="height: 340px">
                        <div class="x_content">
                            <div class="row">
                                <div class="pull-right">
                                    <button class="btn btn-default" @click="openEditModal">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-5 col-xs-12">
                                <form>
                                    <div>
                                        <img src="" class="img-responsive" id="photo_src" :src="me.profile_photo_url" />
                                        <div id="progress" style="padding:4px 0 4px 0">
                                            <div class="bar" style="width:0%;background-color:green;display:block;height:12px;">&nbsp;</div>
                                        </div>
                                        <br />
                                        <label class="btn btn-primary btn-file">
                                            Upload Photo
                                            <input style="display: none;" id="fileupload" type="file" name="photo" class="file-input" data-url="<?php echo Url('/ajax/admin/upp') ?>" style="color: transparent;">
                                        </label>

                                        <?php echo csrf_field() ?>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-7">
                                <b><h4>{{ me.full_name }}</h4></b>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{me.email}}</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile:</th>
                                        <td>{{me.mobile}}</td>
                                    </tr>
                                    <tr>
                                        <th>Skype:</th>
                                        <td>{{ me.skype }}</td>
                                    </tr>
                                    <tr>
                                        <th>QQ:</th>
                                        <td>{{ me.qq }}</td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6"  >
                    <div class="x_panel tile" style="height: 340px;">
                        <div class="x_content">
                            <form id="cForm">
                            <div>
                                <h4> Change Password </h4>
                                <hr />
                                <div class="form-group">
                                    <label for="password">Current Password</label>
                                    <input type="password" name="current_pass" value="" id="current_pass" class="form-control pass" />
                                </div>
                                <div class="form-group">
                                    <label for="new_password"> New Password </label>
                                    <input type="password" name="new_pass" value="" id="new_pass" class="form-control pass" />
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password"> Confirm Password </label>
                                    <input type="password" name="confirm_pass" value="" id="" class="form-control pass" />
                                </div>
                                <div class="form-group">
                                    <a href="javascript:" class="btn btn-primary" @click="changePassword" v-html="changing_pass ? spinner : 'Change Password' "></a>
                                </div>
                            </div>
                                <?php echo csrf_field() ?>
                            </form>
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
                <div class="modal-body">
                    <div class="panel panel-white">
                        <form id="pForm">
                            <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" name="first_name" value="" id="first_name" class="form-control" v-model="me.first_name" />
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" name="last_name" value="" id="last_name" class="form-control" v-model="me.last_name" />
                                    </div>
                                    <div class="form-group">
                                        <label for="skype">Skype</label>
                                        <input type="text" name="skype" value="" id="skype" class="form-control" v-model="me.skype"  />
                                    </div>
                                    <div class="form-group">
                                        <label for="qq">QQ</label>
                                        <input type="text" name="qq" value="" id="qq" class="form-control" v-model="me.qq"  />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" value="" id="email" class="form-control" v-model="me.email" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input type="text" name="mobile" value="" id="mobile" class="form-control" v-model="me.mobile"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="landline">Landline</label>
                                        <input type="text" name="landline" value="" id="landline" class="form-control" v-model="me.landline"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                            <input type="hidden" name="id" id="id" value="" :value="me.id"/>
                            <?php echo csrf_field() ?>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="saveProfile" v-html="saving ? spinner : 'Save'"></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

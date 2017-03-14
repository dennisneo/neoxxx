<div id="tDiv">
    <form method="post" id="t-form">
    <div class="row">
        <div class="col-lg-12">
        <div class="x_panel tile">
            <div class="x_content">

                <div class="pull-right">
                    <a href="javascript:" class="btn btn-primary" v-on:click="save()"> Save </a>
                    <a href="<?php echo Url('admin/teacher/'.$u->id) ?>" class="btn btn-default"> Cancel </a>
                </div>
                <h3>Personal Details</h3>
                <hr />
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <?php echo \Form::text( 'last_name' , $u->last_name , [ 'class' => 'form-control' , 'id'=>'last_name' ] ) ?>
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <?php echo \Form::text( 'first_name' , $u->first_name , [ 'class' => 'form-control' , 'id'=>'first_name' ] ) ?>
                    </div>
                    <div class="form-group">
                        <label for="middle_name">Middle Name</label>
                        <?php echo \Form::text( 'middle_name' , $u->middle_name , [ 'class' => 'form-control' , 'id'=>'middle_name' ] ) ?>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <?php echo \Form::select( 'gender', [ 'M'=>'Male' , 'F'=>'Female' ] , $u->gender , [ 'class' => 'form-control' , 'id'=>'gender' ] ) ?>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday</label><br />
                        <input type="text" class="form-control" id="date1" data-format="YYYY-MM-DD" data-template="MMM D YYYY" name="birthday" value="<?php echo $u->birthday ?>">
                    </div>
                </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <?php echo \Form::text( 'email' , $u->email , [ 'class' => 'form-control' , 'id'=>'email' ] ) ?>
                    </div>
                    <div class="form-group">
                        <label for="mobile">Contact Number</label>
                        <?php echo \Form::text( 'mobile' , $u->mobile , [ 'class' => 'form-control' , 'id'=>'mobile' ] ) ?>
                    </div>
                    <div class="form-group">
                        <label for="skype">Skype</label>
                        <?php echo \Form::text( 'skype' , $u->skype , [ 'class' => 'form-control' , 'id'=>'skype' ] ) ?>
                    </div>
                    <div class="form-group">
                        <label for="qq">QQ</label>
                        <?php echo \Form::text( 'qq' , $u->qq , [ 'class' => 'form-control' , 'id'=>'qq' ] ) ?>
                    </div>
                </div>
                </div>
                <div class="row">

                    <div class="col-lg-6">
                        <h3>Address</h3><hr />
                        <div class="form-group">
                            <label for="address">Address</label>
                            <?php echo \Form::text( 'address' , $u->address , [ 'class' => 'form-control' , 'id'=>'address' ] ) ?>
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <?php echo  \App\Http\Models\Locations\Countries::selectList( ['default' => $u->country] ); ?>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <?php echo \Form::text( 'city' , $u->city , [ 'class' => 'form-control' , 'id'=>'city' ] ) ?>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <h3>Timezone</h3>
                        <hr />
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="timezone">Timezone</label>
                                <?php echo \Helpers\Html::timezoneSelect( $u->timezone ) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <h3>Teacher Type</h3>
                        <hr />
                        <div class="form-group col-lg-3" >
                            <?php
                                echo \App\Models\Users\TeacherEntity::typeSelection( $p->type );
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h3>Salary Rate</h3>
                        <hr />
                        <div class="form-group col-lg-3" >
                            $ <?php echo \Form::text( 'rate_per_hr' , $u->rate_per_hr , [ 'class' => 'form-control' , 'id'=>'city' ] ) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <hr />
                    <a href="javascript:" class="btn btn-primary" v-on:click="save()"> Save </a>
                    <a href="<?php echo Url('admin/teacher/'.$u->id) ?>" class="btn btn-default"> Cancel </a>
                </div>
            </div>
        </div>
        </div>

    </div>
        <?php echo csrf_field() ?>
        <input type="hidden" name="id" id="user_id" value="<?php echo $u->id ?>" />
    </form>
    <div class="clearfix"></div>
</div>



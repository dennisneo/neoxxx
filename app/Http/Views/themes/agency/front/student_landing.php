<script src='https://www.google.com/recaptcha/api.js'></script>
<div id="sDiv">
    <h4>Student Registration Form</h4>
    <i>* Required fields</i>
    <form method="POST" id="sForm">
        <div class="col-lg-12" style="border: 1px solid #CFCFCF">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="first_name"><h5>First Name *</h5></label>
                    <?php echo \Form::text( 'first_name' , $r->first_name , [ 'class' => 'form-control' , 'id'=>'first_name' ,  "required" ] ) ?>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="last_name"><h5>Last Name *</h5></label>
                    <?php echo \Form::text( 'last_name' , $r->last_name , [ 'class' => 'form-control' , 'id'=>'last_name' ,  "required" ] ) ?>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <h5>Email *</h5>
                    <?php echo \Form::email( 'email' , $r->email , [ 'class' => 'form-control' , 'id'=>'email' , 'required' ] ) ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <h5>QQ ID *</h5>
                    <?php echo \Form::text( 'qq' , $r->skype , [ 'class' => 'form-control' , 'id'=>'qq' , 'required'] ) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <h5>Mobile number *</h5>
                    <?php echo \Form::text( 'mobile' , $r->mobile , [ 'class' => 'form-control' , 'id'=>'mobile' , 'required' ] ) ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <h5>Skype</h5>
                    <?php echo \Form::text( 'skype' , $r->landline , [ 'class' => 'form-control' , 'id'=>'skype' ] ) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <h5>Country * </h5>
                    <select class="form-control" name="country">
                        <option value="CH">China</option>
                        <option value="JP">Japan</option>
                        <option value="KOR">Korea</option>
                        <option value="MY">Malaysia</option>
                        <option value="SIN">Singapore</option>
                        <option value="TW">Taiwan</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <h5>City *</h5>
                    <?php echo \Form::text( 'city' , $r->city , [ 'class' => 'form-control' , 'id'=>'city' , 'required' ] ) ?>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <h5> Timezone *</h5>
                        <?php echo \Helpers\Html::timezoneSelect( ); ?>
                    </div>
                </div>
                <div class="col-lg-6">
                  
                </div>
            </div>
        <div class="col-lg-12">
            <div class="form-group">
            <h5>Learning Objectives</h5>
                <?php echo App\Models\LearningGoals\LearningGoals::checkboxList(); ?>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <h5>How is your English?</h5>
                <input type="radio" name="level" value="1" /> Still Starting &nbsp;&nbsp;
                <input type="radio" name="level" value="2" /> Not Good &nbsp;&nbsp;
                <input type="radio" name="level" value="3" /> Good &nbsp;&nbsp;
                <input type="radio" name="level" value="4" /> Very Good &nbsp;&nbsp;
            </div>
        </div>
        <div class="col-lg-12">
            <div class="g-recaptcha" data-sitekey="<?php echo env( 'RECAPTCHA_KEY' ); ?>"></div>
        </div>
        <div class="col-lg-12">
            <hr />
            <div class="form-group">
               <a href="javascript:" class="btn btn-success" id="submit" v-on:click="submit()"> <b>Submit</b> </a>
            </div>
        </div>

    </div>
        <input type="hidden" name="is_validated" id="is_validated" value="0" />
        <?php echo csrf_field() ?>
    </form>
</div>

<div class="col-lg-12" style="height:200px">

</div>



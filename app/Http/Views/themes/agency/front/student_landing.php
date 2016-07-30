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
                <?php echo \Form::text( 'skype' , $r->skype , [ 'class' => 'form-control' , 'id'=>'skype' , 'required'] ) ?>
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
                <select class="form-control">
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
    <div class="col-lg-12">
        <div class="form-group">
        <h5>Learning Objectives</h5>
            <input type="radio" name="exp" value="No teaching experience" /> No teaching experience <br />
            <input type="radio" name="exp" value="Had English teaching experience with young kids" /> Had English teaching experience with young kids <br />
            <input type="radio" name="exp" value="Had English teaching experience with adults" /> Had English teaching experience with adults <br />
            <input type="radio" name="exp" value="Had English teaching experience with both young kids and adults" /> Had English teaching experience with both young kids and adults <br />
            <input type="radio" name="exp" value="Had teaching experience with subjects other than English" /> Had teaching experience with subjects other than English  <br />
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <h5>How is your English?</h5>
            <input type="checkbox" name="certificates[]" value="LET" />  &nbsp;&nbsp;
            <input type="checkbox" name="certificates[]" value="LET" /> Still Starting &nbsp;&nbsp;
            <input type="checkbox" name="certificates[]" value="LET" /> Good &nbsp;&nbsp;
            <input type="checkbox" name="certificates[]" value="" /> Very Good &nbsp;&nbsp;
            <input type="checkbox" name="certificates[]" value="" /> Exceptional &nbsp;&nbsp;
        </div>
    </div>

    <div class="col-lg-12">
        <hr />
        <div class="form-group">
           <button class="btn btn-primary" id="sb"> Submit </button>
           <input type="hidden" name="_token" value="<?php echo \Session::token() ?>">
        </div>
    </div>
</div>
</form>
<div class="col-lg-12" style="height:200px">

</div>
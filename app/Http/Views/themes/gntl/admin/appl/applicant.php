<!--
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
-->
<style>
    .bless{
        border: none;
    }
</style>
<div id="aDiv">
<div class="x_panel tile" style="">
    <div class="x_content">
        <div class=row" style="padding:24px 18px 18px 18px;">
        <div class="pull-right">
            <button class="btn btn-success" v-on:click="updateStatus()"> Update Status </button>
        </div>
        <h1 style="display: inline"> <?php echo $a->displayName(); ?> </h1>
        <b>Applicant</b>
    </div>
        <div class="row">
        <div class="col-lg-6">
        <div class="x_panel tile">
            <div class="x_content">
                <h3>Personal Details</h3>
                <table class='table striped'>
                    <tr>
                        <td style="width:120px;"> Age: </td>
                        <td> 35 </td>
                    </tr>
                    <tr>
                        <td> Gender: </td>
                        <td> M </td>
                    </tr>
                    <tr>
                        <td> Email: </td>
                        <td> <?php echo $a->email ?> </td>
                    </tr>
                    <tr>
                        <td> Mobile Number: </td>
                        <td> <?php echo $a->mobile ?> </td>
                    </tr>
                    <tr>
                        <td> Landline: </td>
                        <td> <?php echo $a->landline ?> </td>
                    </tr>
                    <tr>
                        <td> Country: </td>
                        <td> <?php echo $a->country ?></td>
                    </tr>
                    <tr>
                        <td> Date Applied: </td>
                        <td> <?php echo $a->created_at ?></td>
                    </tr>
                    <tr>
                        <td> Timezone: </td>
                        <td></td>
                    </tr>
                </table>



            </div>
        </div>
        </div>
        <div class="col-lg-6">
            <div class="x_panel">
                <ul class="nav nav-tabs">
                    <li role="presentation" data-tab="tab1" class="tab active"><a href="#">Requirements</a></li>
                    <li role="presentation" data-tab="tab2" class="tab"><a href="#">Notes</a></li>
                </ul>

                <br />
                <div id="tab1" class="tabDiv">
                    <div>
                        <h4>Requirements:</h4>
                    </div>
                    <div>
                        <form id="rForm">
                        <input type="hidden" name="applicant_id" id="applicant_id" value="<?php echo $a->id ?>" />
                        <ul class="list-group">
                            <li class="list-group-item" >
                                <div class="pull-right" >
                                    <input type="checkbox" class="req" id="valid_credentials" name="valid_credentials" value="1">
                                </div>
                                Valid Credentials
                            </li>
                            <li class="list-group-item">
                                <div class="pull-right" >
                                    <input type="checkbox" class="req" id="fast_internet" name="fast_internet" value="1">
                                </div>
                                Reliable and Fast Internet Connection
                            </li>
                            <li class="list-group-item">
                                <div class="pull-right" >
                                    <input type="checkbox" class="req" id="comfortable_home_office" name="comfortable_home_office" value="1">
                                </div>
                                Comfortable Home Office
                            </li>
                            <li class="list-group-item">
                                <div class="pull-right" >
                                    <input type="checkbox" class="req" name="audio_recording" id="audio_recording" value="1">
                                </div>
                                Audio Recording
                            </li>
                            <li class="list-group-item">
                                <div class="pull-right" >
                                    <input type="checkbox" class="req" name="appropriate_schedule" id="appropriate_schedule" value="1">
                                </div>
                                Appropriate Schedule
                            </li>
                        </ul>
                        <?php echo csrf_field() ?>
                        </form>
                        <div>
                            <button class="btn btn-primary" v-on:click="saveRequirements" id="rqBtn"> Save Requirements </button>
                        </div>
                    </div>

                    <div>
                        <h4>Resume / CV </h4>
                        <hr />
                        <form id="cvForm">
                        <?php echo csrf_field() ?>
                        <input type="hidden" name="applicant_id" id="applicant_id" value="<?php echo $a->id ?>" />
                        <div class="" id="" v-show="req.cv">
                            <a href="<?php echo Url( 'download/cv/'.\Helpers\Text::convertInt( $a->id ) ) ?>" class="btn btn-primary">
                                Download CV
                            </a>
                            <a href="javascript:" class="btn btn-danger" @click="deleteCV( req.applicant_id )" v-html="loading ? spinner : 'Delete' ">  </a>
                        </div>
                        <div v-show=" ! req.cv ">
                            
                            <input id="cv" type="file" name="cv" class="file-input" data-url="<?php echo Url('/ajax/admin/applicant/upload/cv') ?>" style="color: transparent;">
                            <div id="progress" style="padding:4px 0 4px 0">
                                <div class="bar" style="width:0%;background-color:green;display:block;height:12px;">&nbsp;</div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div>
                    </div>
                </div >

                <div id="tab2" class="tabDiv hide">
                    <form id="nForm">
                    <div class="form-group">
                        <label for="note">Write a note</label>
                        <?php echo \Form::textarea( 'note' , '' , [ 'class' => 'form-control' , 'id'=>'note' , 'style' =>'height:72px' ] ) ?>
                    </div>
                    <div>
                        <a href="javascript:" class="btn btn-primary" @click="saveNote"> Save Note </a>
                    </div>
                        <?php echo csrf_field() ?>
                        <input type="hidden" name="note_to" id="note_to" value="<?php echo $a->id ?>" />
                        <input type="hidden" name="note_id" id="note_id" value="" />
                    </form>

                    <div>
                        <ul class="list-group">
                            <li class="list-group-item" v-for="n in notes | orderBy 'timestamp' -1 ">
                                <b>{{n.from}} -</b>  {{n.posted_at_human}}
                                <br />
                                {{ n.note }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

        <div class="clearfix"></div>
    </div>
    </div>
    <div id="aModal" class="modal fade">
        <div class="modal-dialog">
            <form id="aForm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Change Status</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" name="status">
                            <option value="promoted"> Promote as Teacher </option>
                            <option value="archive"> Send to Archive </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="" v-on:click="saveStatus">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
                <?php echo csrf_field(); ?>
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $a->id ?>" />
            </form>
        </div>
    </div>
</div>



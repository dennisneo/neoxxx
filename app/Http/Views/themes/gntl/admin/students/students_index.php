<style>
    tr.s{
        cursor: pointer;
    }
</style>
<div id="sDiv">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
        <div class="col-lg-8">
            <h3> <b>Students</b> </h3>
        </div>
        <div class="col-lg-4" style="">
            <div class="input-group">
                <input type="text" id="q" v-model="q" class="form-control" />
                <span class="input-group-btn"><button class="btn btn-default"> <i class="fa fa-search"></i> Search</button></span>
            </div>
        </div>

    </div>
        <div class="row">
        <table class="table table-striped">
            <tr>
                <th style="width: 48px"></th>
                <th> Name </th>
                <th> Status </th>
                <th></th>
            </tr>
            <tr class="loading" v-bind:class=" students.length > 0 ? 'hide' : 'show' ">
                <td colspan="4">
                    <i class="fa fa-refresh fa-spin"></i> Loading...
                </td>
            </tr>
            <tr class="loading" v-bind:class=" students.length > 0 ? 'hide' : 'show' ">
                <td colspan="4">

                </td>
            </tr>
            <tr v-for="s in students" class="s" >
                <td v-on:click="openStudentView(s.id)"><img src="" style="width:64px" v-bind:src="s.profile_photo_url"/></td>
                <td style=""><b>{{ s.full_name }}</b>
                    <br />{{s.location}}
                </td>
                <td>{{ s.status }}</td>
                <td>
                    <div class="dropdown pull-right" >
                        <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu" style="padding:12px;font-size: 1em">
                            <li><a href="javascript:" v-on:click="openStudentView(s.id)"> <i class="fa fa-edit"></i> View </a></li>
                            <li><a href="javascript:" v-on:click="openStudentContactInfo(s.id)"> <i class="fa fa-edit"></i> Edit Contact Info </a></li>
                            <li><a href="<?php echo Url('admin/records') ?>"><i class="fa fa-bar-chart-o"></i> Performance Record </a></li>
                            <li><a href="<?php echo Url('admin/teacher/schedule') ?>/{{ s.id }}"> <i class="fa fa-calendar"></i> Set Schedule </a></li>
                            <li><a href="javascript:" v-on:click="openNotificationModal()"> <i class="fa fa-comment"></i> Send Message </a></li>
                            <li><a href="javascript:" v-on:click="openPlacementModal( s.id )"> <i class="fa fa-book"></i> Placement Exam Results </a></li>
                            <li><a href="javascript:" v-on:click="openResetPasswordModal( s.id )"> <i class="fa fa-book"></i> Reset Password </a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        </table>
            <br /><br /><br /><br /><br /><br />
    </div>
         </div>
    </div>
    <div id="studentViewModal" class="modal fade">
        <div class="modal-dialog" style="width:90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><b>Student Information</b></h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-4">
                        <div class="col-lg-6">
                            <img src="" v-bind:src="student.profile_photo_url" class="img-responsive" />
                        </div>
                        <div class="col-lg-6">
                            <div>
                            <h2><b>{{student.full_name}}</b></h2>
                            {{student.location}}<br />
                            {{student.gender == 'M' ? 'Male' : 'Female' }} {{student.birthday}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                            <hr />

                            <table style="width:100%">
                                <tr>
                                    <td style="width:90px"> Email: </td>
                                    <td> {{student.email}}</td>
                                </tr>
                                <tr>
                                    <td> QQ: </td>
                                    <td> {{student.qq}}</td>
                                </tr>
                                <tr>
                                    <td> Skype: </td>
                                    <td> {{student.skype}}</td>
                                </tr>
                                <tr>
                                    <td> Phone: </td>
                                    <td> {{student.mobile}}</td>
                                </tr>
                            </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <ul class="nav nav-tabs">
                            <li role="presentation" data-tab="schedule" id="schedule-tab" class="li-tab active"><a href="#">Class Schedule</a></li>
                            <li role="presentation" data-tab="notes" id="notes-tab" class="li-tab"><a href="#">Notes</a></li>
                            <li role="presentation" data-tab="pe" id="pe-tab" class="li-tab"><a href="#">Placement Exam</a></li>
                        </ul>

                        <div class="tab-content" id="schedule">

                            <br />
                            <table class="table table-striped">
                                <tr>
                                    <th>Teacher</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                <tr v-for="c in classes">
                                    <td><a href="<?php echo Url('admin/teacher') ?>/{{c.tid}}" target="_blank">{{c.teacher_short_name}}</a></td>
                                    <td>{{c.day}}</td>
                                    <td>{{c.time}}</td>
                                    <td>{{c.duration}}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>

                        <div class="hide tab-content" id="notes">
                            <br />
                            <form id="nForm">
                                <div class="form-group">
                                    <?php echo \Form::textarea( 'note' , '' , [ 'class' => 'form-control' , 'style'=> 'height:120px', 'id'=>'note' ] ) ?>
                                </div>
                                <a href="javascript:" class="btn btn-primary" id="note-btn" v-on:click="saveNote()"> Save Note </a>
                                <?php echo csrf_field() ?>
                                <input type="hidden" name="student_id" id="student_id" value="{{student.id}}" />

                            <hr />
                                <div v-for="n in notes" style="border-bottom:1px solid #EEEEEE;padding:12px">
                                    <div class="pull-right">
                                        <i>{{n.posted_at_human}}</i>

                                    </div>
                                    <div style="">
                                        <img src="{{ n.profile_photo_url }}" class="" style="width:32px" />
                                        <b>{{n.first_name+' '+n.last_name}}</b>
                                    </div>
                                    <div style="margin-top:18px">
                                        {{n.note}}
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="hide tab-content" id="pe">
                            <br />
                            <table class="table table-striped">
                                <tr>
                                    <th></th>
                                    <th>Session ID</th>
                                    <th>Date Taken</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                <tr v-for="e in exams">
                                    <td></td>
                                    <td>{{e.session_id}}</td>
                                    <td>{{e.started_at}}</td>
                                    <td>{{ e.status }}</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <div id="placementModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Learning Goals</th>
                            <th>Items</th>
                            <th>Percentage Score</th>
                            <th>Taken At</th>
                            <th>Completed</th>
                        </tr>
                        <tr v-bind:class=" exams.length ? 'hide' : '' ">
                            <td> No record found </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr v-bind:class=" exams.length ? 'hide' : '' ">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr v-for="e in exams" v-bind:class=" exams.length ? '' : 'hide' ">
                            <td></td>
                            <td>{{e.item_count}}</td>
                            <td>{{e.rating}}</td>
                            <td>{{ e.started_at }}</td>
                            <td>{{ e.item_count == e.current_item ? 'Yes' : 'No' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <div class="" v-bind:class="">

                    </div>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
            </div>
        </div>
    </div>
    <div id="resetPasswordModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div id="rdiv">
                        Are you sure you want to reset the password of the student {{ student.full_name }} ?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="resetPassword">Reset Password</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="editContactModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Contact Info</h4>
                </div>
                <form id="contactForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" value="" id="first_name" class="form-control" v-model="student.first_name" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" value="" id="email" class="form-control" v-model="student.email" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" value="" id="last_name" class="form-control" v-model="student.last_name" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="qq">QQ ID*</label>
                                <input type="text" name="qq" value="" id="qq" class="form-control" v-model="student.last_name" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" name="middle_name" value="" id="middle_name" class="form-control" v-model="student.middle_name" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="skype">Skype ID</label>
                                <input type="text" name="skype" value="" id="skype" class="form-control" v-model="student.skype" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="country_id">Country {{ student.country }} </label>
                                <select name="country" class="form-control" id="country" v-model="student.country">
                                    <option value="" v-for="c in countries" :value="c.code"> {{c.country}} </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mobile">Mobile Number</label>
                                <input type="text" name="mobile" value="" id="mobile" class="form-control" v-model="student.mobile" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="city"> City </label>
                                <input type="text" name="city" value="" id="city" class="form-control" v-model="student.city" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div id="div-date">
                                <div class="form-group">
                                    <label for="birthday"> Birthday </label>
                                    <input type="text" class="form-control" id="date1" data-format="YYYY-MM-DD" data-template="MMM D YYYY" name="birthday" value="" v-model="student.birthday" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php echo csrf_field() ?>
                    <input type="hidden" name="id" id="id" value="" v-model="student.id" />
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="spButton" @click="saveContactForm"> Save </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

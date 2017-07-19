<style>
    td.hl{
        font-weight: bold;
    }
</style>

<div id="tDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <h3><b>Class Schedules</b></h3>
                <br />
                <form id="searchForm" method="POST">
                <div class="row" style="padding:4px;margin:2px;margin-bottom:12px;background-color: #EFEFEF">
                    <div class="form-group">
                        <div class="col-lg-2">
                            <label style="font-weight: normal">Date From:</label> <?php echo \Form::text( 'date_from' , '' , [ 'class' => 'form-control inline' , 'id'=>'date_from' ] ) ?>
                        </div>
                        <div class="col-lg-2">
                            <label style="font-weight: normal">Date To:</label> <?php echo \Form::text( 'date_to' , '' , [ 'class' => 'form-control inline' , 'id'=>'date_to' ] ) ?>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="student" style="font-weight: normal"> Teacher</label>
                                <input type="text" name="teacher" value="" id="teacher" class="form-control" />

                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label style="font-weight: normal">Student</label>
                                <input type="text" name="student" value="" id="student" class="form-control" />

                            </div>
                        </div>

                        <div class="col-lg-2">
                            &nbsp;<br />
                            <a href="javascript:" class="btn btn-primary" v-on:click="search()"> Search </a>
                        </div>
                    </div>
                </div>
                    <input type="hidden" name="tid" id="teacher_id" value="" v-model="search_teacher_id" />
                    <input type="hidden" name="sid" id="student_id" value="" v-model="search_student_id" />
                    <!---
                    <input type="hidden" name="tid" id="tid" value="<?php echo isset( $teacher_id ) ? $teacher_id : 0 ?>" />
                    <input type="hidden" name="sid" id="sid" value="" />
                    -->
                    <input type="hidden" name="page" id="page" value="1" />
                </form>
                <div style="min-height:320px">
                <table class="table table-striped">
                    <tr>
                        <th></th>
                        <th>Student</th>
                        <th>Teacher</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    <tr v-bind:class="sessions.length > 0 ? 'hide' : '' " >
                        <td colspan="6"><span class="loading"><i class="fa fa-spin fa-refresh"></i></span></td>
                    </tr>
                    <tr v-bind:class="sessions.length > 0 ? 'hide' : '' " >
                        <td colspan="6"></td>
                    </tr>
                    <tr v-for="s in sessions" v-cloak>
                        <td></td>
                        <td><a href="javascript:" v-on:click="">{{s.s_fname+' '+s.s_lname}}</a></td>
                        <td><a href="javascript:" v-on:click="">{{s.t_fname+' '+s.t_lname}}</a></td>
                        <td>{{s.day}} {{s.time}}</td>
                        <td>{{s.time}}</td>
                        <td>{{s.class_status}}</td>
                        <td>
                            <div class="dropdown pull-right" >
                                <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu" style="padding:4px">
                                    <li><a href="javascript:" v-on:click="openStudentInfoModal( s.student_id )"> <i class="fa fa-user"></i> Student Info </a></li>
                                    <li><a href="javascript:" v-on:click="openClassRecord( s.class_id )"> <i class="fa fa-edit"></i> Class Record </a></li>
                                    <li><a href="javascript:" v-on:click="openNotificationModal( s.ccid )"> <i class="fa fa-comment"></i> Notify </a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </table>
                </div>
                <ul class="pagination" v-bind:class="page_count.length == 1 ? 'hide' : ''  ">
                    <li v-bind:class=" current_page > 1 ? '' : 'hide' "><a href="javascript:"  v-on:click="goToPrev" data-page="">Previous</a></li>
                    <li v-for="pc in page_count" v-bind:class="current_page == pc ? 'active': '' ">
                        <a href="javascript:" v-on:click="goToPage" data-page="" v-bind:data-page="pc">{{pc}}</a>
                    </li>
                    <li v-bind:class=" current_page < page_count.length ? '' : 'hide' "><a href="javascript:" @click="goToNext" >Next</a></li>
                </ul>

            </div>
        </div>
    </div>

    <div id="classRecordModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <form id="sForm">
                <div class="modal-body">
                    <div class="form-group">
                        <table id="t">
                            <tr>
                                <td style="width: 25%"> <label for="class_status">Class Status</label> </td>
                                <td style="width: 50%">
                                    <?php echo App\Models\ClassSessions\ClassSessions::statusSelect(); ?>
                                </td>
                                <td></td>
                            </tr>
                            <tr style="">
                                <td style="vertical-align: top;"> <label for="comment">Actual Duration</label> </td>
                                <td style="padding: 4px">
                                    <?php echo App\Models\ClassSessions\ClassSessions::durationSelect(); ?>
                                </td>
                                <td></td>
                            </tr>
                            <tr style="">
                                <td style="vertical-align: top;"> <label for="comment">Performance Notes</label> </td>
                                <td style="padding: 4px">
                                    <?php echo \Form::textarea( 'performance_notes' , '{{session.performance_notes}}' , [ 'class' => 'form-control' , 'style' => 'height:90px', 'id'=>'performance_notes' ] ) ?>
                                </td>
                                <td> Note down how the class went and what needs improvement  </td>
                            </tr>
                            <tr style="">
                                <td style="vertical-align: top;"> <label for="comment">Comment</label> </td>
                                <td style="padding: 4px">
                                    <?php echo \Form::textarea( 'comments' , '{{session.comments}}' , [ 'class' => 'form-control' , 'style' => 'height:90px', 'id'=>'comments' ] ) ?>
                                </td>
                                <td>
                                    Other notes not related to performance
                                </td>
                            </tr>
                            <tr style="">
                                <td style="vertical-align: top;"> <label for="comment">Upload Audio File</label> </td>
                                <td style="padding: 4px">
                                    <div class="udiv hide" id="hasNoAudio">
                                        <input id="fileupload" type="file" name="audio" class="file-input" data-url="<?php echo Url('/ajax/teacher/ua') ?>" style="color: transparent;">
                                        <div id="progress" style="padding:4px 0 4px 0">
                                            <div class="bar" style="width:0%;background-color:green;display:block;height:12px;">&nbsp;</div>
                                        </div>
                                    </div>
                                    <div class="udiv hide" id="hasAudio">
                                        <audio src="" id="audio_control" controls></audio>
                                        <a href="javascript:" class="btn btn-danger" v-on:click="deleteAudio()"> <i class="fa fa-trash-o"></i> Delete Audio File</a>
                                    </div>
                                </td>
                                <td>
                                    You are required to record the class sesssion conversation and upload it here.
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" v-on:click="saveClassRecord()">Save changes</button>
                </div>
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="class_id" id="class_id" value="{{session.class_id}}" />
                    <input type="hidden" name="ccid" id="ccid" value="{{session.ccid}}" />
                </form>
            </div>
        </div>
    </div>

    <div id="notificationModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Send Message to Email  and Mobile Phone</h4>
                </div>
                <form id="nForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Message</label>
                        <?php echo \Form::textarea( 'notification_message' , '' ,
                            [ 'class' => 'form-control' , 'style' => 'height:120px', 'id'=>'notification_message' ] )
                        ?>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" v-on:click="sendNotification()"> Send </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="studentInfoModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Student Info</h4>
            </div>
            <div class="modal-body">
                <div>
                    <b>Personal and Contact Info</b>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <table class="table" style="margin-top: 24px">
                        <tr>
                            <td>Name:</td>
                            <td class="hl">{{ student.full_name }}</td>
                        </tr>
                        <tr>
                            <td>Gender:</td>
                            <td class="hl">{{ student.gender }}</td>
                        </tr>
                        <tr>
                            <td>Age:</td>
                            <td class="hl"></td>
                        </tr>
                        <tr>
                            <td>Location:</td>
                            <td class="hl">{{ student.location }}</td>
                        </tr>
                        <tr>
                            <td> Timezone: </td>
                            <td class="hl"> {{ student.timezone }} </td>
                        </tr>
                    </table>
                </div>
                    <div class="col-lg-6">
                    <table class="table" style="margin-top: 24px">
                        <tr>
                            <td>Skype ID:</td>
                            <td class="hl"> {{ student.skype }}</td>
                        </tr>
                        <tr>
                            <td>QQ ID:</td>
                            <td class="hl">{{ student.qq }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td class="hl">{{ student.email }}</td>
                        </tr>
                        <tr>
                            <td>Mobile Phone:</td>
                            <td class="hl"> {{ student.mobile }} </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="hl"></td>
                        </tr>
                    </table>
                </div>
                </div>
                <b>Class Details</b>
                <table class="table" style="margin-top: 24px">
                    <tr>
                        <td>Learning Purpose:</td>
                        <td class="">
                            <ul>
                                <li :class="learning_info.length ? 'hide' : '' "> No learning purpose found </li>
                                <li v-for="l in learning_info">{{ l.goal }}</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Materials / Textbooks:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Message from Student:</td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        </div>
    </div>

</div>


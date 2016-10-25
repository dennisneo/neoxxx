<div id="ssDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <h3><b>Class Schedules</b></h3>
                <br />
                <table class="table table-striped">
                    <tr>
                        <th></th>
                        <th>Session ID</th>
                        <th>Teacher</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    <tr v-bind:class="sessions.length > 0 ? 'hide' : '' " >
                        <td colspan="5"><span class="loading"><i class="fa fa-spin fa-refresh"></i></span></td>
                    </tr>
                    <tr v-bind:class="sessions.length > 0 ? 'hide' : '' " >
                        <td colspan="5"></td>
                    </tr>
                    <tr v-for="s in sessions">
                        <td></td>
                        <td>{{s.cid}}</td>
                        <td>{{s.teacher_short_name}}</td>
                        <td>{{s.day}}</td>
                        <td>{{s.time}}</td>
                        <td>{{s.class_status}}</td>
                        <td>
                            <div class="dropdown pull-right">
                                <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu" style="padding:4px">
                                    <li><a href="javascript:">Send Notification to Teacher</a></li>
                                    <li class="" v-bind:class="s.class_status == 'Done' ? '' : 'hide'  ">
                                        <a href="javascript:" v-on:click="evaluateTeacherModal( s.ccid , s.teacher_short_name+' - '+s.day )"> <i class="fa fa-user"></i> Evaluate Teacher </a>
                                    </li>

                                </ul>
                            </div>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div id="evaluationModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"> Rate Class Session ( <span id="detail"></span> )</h4>
                </div>
                <form id="ratingForm">
                <div class="modal-body">
                    <table class="table table-striped">
                        <tr>
                            <td>Degree of Satisfaction</td>
                            <td>
                                <a href="javascript:" v-on:click="checkStar(1 , 'st')"><i class="fa fa-star-o fa-lg" class="iq" id="st1"></i></a>
                                <a href="javascript:" v-on:click="checkStar(2, 'st')"><i class="fa fa-star-o fa-lg" class="iq" id="st2"></i></a>
                                <a href="javascript:" v-on:click="checkStar(3, 'st')"><i class="fa fa-star-o fa-lg" class="iq" id="st3"></i></a>
                                <a href="javascript:" v-on:click="checkStar(4, 'st')"><i class="fa fa-star-o fa-lg" class="iq" id="st4"></i></a>
                                <a href="javascript:" v-on:click="checkStar(5, 'st')"><i class="fa fa-star-o fa-lg" class="iq" id="st5"></i></a>
                                <input type="hidden" name="st" id="st" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>Internet Quality</td>
                            <td>
                                <a href="javascript:" v-on:click="checkStar(1 , 'iq')"><i class="fa fa-star-o fa-lg" class="iq" id="iq1"></i></a>
                                <a href="javascript:" v-on:click="checkStar(2, 'iq')"><i class="fa fa-star-o fa-lg" class="iq" id="iq2"></i></a>
                                <a href="javascript:" v-on:click="checkStar(3, 'iq')"><i class="fa fa-star-o fa-lg" class="iq" id="iq3"></i></a>
                                <a href="javascript:" v-on:click="checkStar(4, 'iq')"><i class="fa fa-star-o fa-lg" class="iq" id="iq4"></i></a>
                                <a href="javascript:" v-on:click="checkStar(5, 'iq')"><i class="fa fa-star-o fa-lg" class="iq" id="iq5"></i></a>
                                <input type="hidden" name="iq" id="iq" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>Pronunciation</td>
                            <td>
                                <a href="javascript:" v-on:click="checkStar(1 , 'p')"><i class="fa fa-star-o fa-lg" class="p" id="p1"></i></a>
                                <a href="javascript:" v-on:click="checkStar(2, 'p')"><i class="fa fa-star-o fa-lg" class="p" id="p2"></i></a>
                                <a href="javascript:" v-on:click="checkStar(3, 'p')"><i class="fa fa-star-o fa-lg" class="p" id="p3"></i></a>
                                <a href="javascript:" v-on:click="checkStar(4, 'p')"><i class="fa fa-star-o fa-lg" class="p" id="p4"></i></a>
                                <a href="javascript:" v-on:click="checkStar(5, 'p')"><i class="fa fa-star-o fa-lg" class="p" id="p5"></i></a>
                                <input type="hidden" name="p" id="p" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>Teaching Skills</td>
                            <td>
                                <a href="javascript:" v-on:click="checkStar(1 , 'ts')"><i class="fa fa-star-o fa-lg" class="ts" id="ts1"></i></a>
                                <a href="javascript:" v-on:click="checkStar(2, 'ts')"><i class="fa fa-star-o fa-lg" class="ts" id="ts2"></i></a>
                                <a href="javascript:" v-on:click="checkStar(3, 'ts')"><i class="fa fa-star-o fa-lg" class="ts" id="ts3"></i></a>
                                <a href="javascript:" v-on:click="checkStar(4, 'ts')"><i class="fa fa-star-o fa-lg" class="ts" id="ts4"></i></a>
                                <a href="javascript:" v-on:click="checkStar(5, 'ts')"><i class="fa fa-star-o fa-lg" class="ts" id="ts5"></i></a>
                                <input type="hidden" name="ts" id="ts" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>Comment</td>
                            <td>
                                <div class="form-group" v-bind:class=" feedback.feedback_id ? 'hide' : '' ">
                                    <?php echo \Form::textarea( 'comment' , '' , [ 'class' => 'form-control' , 'style'=>'height:64px', 'id'=>'comment' ] ) ?>
                                </div>
                                <div v-bind:class=" feedback.feedback_id ? '' : 'hide' ">
                                    {{feedback.comment}}
                                </div>
                            </td>
                        </tr>
                        <tr v-bind:class=" feedback.feedback_id ? '' : 'hide' ">
                            <td> Rated Last</td>
                            <td>
                                {{feedback.added_at}}
                            </td>
                        </tr>
                    </table>
                </div>
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="class_id" id="class_id" value="" />
                </form>
                <div class="modal-footer" v-bind:class=" feedback.feedback_id ? 'hide' : '' ">
                    <a href="javascript:" type="button" class="btn btn-primary" v-on:click="submitFeedback()">Submit Rating</a>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="student_id" id="student_id" value="<?php echo \App\Models\Users\UserEntity::me()->id ?>" />

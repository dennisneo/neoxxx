<div id="tDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_header">
            <div style="float:right">
                <button class="btn btn-primary" @click="openClassRecordModal"> Update </button>
            </div>
            <h3><b>Class Session</b></h3>
        </div>
        <div class="x_content">
            <div class="row">

                <br />
                <table id="tbl" class="table">
                    <tr>
                        <th style="width: 25%">Class Status </th>
                        <td style="width: 50%">
                            <?php echo $class->class_status ?>
                        </td>
                    </tr>
                    <tr style="">
                        <th>Schedule</th>
                        <td style="padding: 4px">
                            <?php echo $class->day.' '.$class->time ?>
                        </td>
                    </tr>
                    <tr style="">
                        <th>Student</th>
                        <td style="padding: 4px">
                            <?php echo $class->student->displayName( 'short' ) ?>
                        </td>
                    </tr>
                    <tr style="">
                        <th>Duration</th>
                        <td style="padding: 4px">
                            <?php echo $class->duration ?> mins
                        </td>

                    </tr>
                    <tr style="">
                        <th>Performance Notes</th>
                        <td style="padding: 4px">
                           <?php echo $class->performance_notes ?>
                        </td>

                    </tr>
                    <tr style="">
                        <th>Comments</th>
                        <td style="padding: 4px">
                            <?php echo $class->comments ?>
                        </td>
                    </tr>
                    <tr style="">
                        <td style="vertical-align: top;"> <label for="comment">Audio File</label> </td>
                        <td style="padding: 4px">

                        </td>
                    </tr>
                </table>
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
                                        <?php echo \Form::textarea( 'performance_notes' , '' , [ 'class' => 'form-control' , 'style' => 'height:90px', 'id'=>'performance_notes' ] ) ?>
                                    </td>
                                    <td> Note down how the class went and what needs improvement  </td>
                                </tr>
                                <tr style="">
                                    <td style="vertical-align: top;"> <label for="comment">Comment</label> </td>
                                    <td style="padding: 4px">
                                        <?php echo \Form::textarea( 'comments' , '' , [ 'class' => 'form-control' , 'style' => 'height:90px', 'id'=>'comments' ] ) ?>
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
                    <input type="hidden" name="class_id" id="class_id" value="<?php echo $class->class_id ?>" />
                    <input type="hidden" name="ccid" id="ccid" value="<?php echo $class->cid ?>" />
                </form>
            </div>
        </div>
    </div>
</div>


 <div id="ftDiv">
    <div class="x_panel tile"  style="min-height:280px">
        <div class="x_title">
            <div class="pull-right">
                <div class="input-group">
                      <input type="text" name="q" id="q" class="form-control" placeholder="Search by name...">
                      <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button" v-on:click="search()"> <i class="fa fa-search"></i> Search </button>
                      </span>
                </div>
            </div>
            <h3><b>Find a Teacher</b></h3>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form id="ftForm">
                <div v-for="t in teachers" class="col-lg-3">
                    <div>
                        <img src="" v-bind:src="t.profile_photo_url" class="img-responsive">
                    </div>
                    <div>
                        <b>{{t.short_name}}</b> <i v-for="r in r( t.rating )" class="fa fa-star" style="color:#ffAA44"></i>
                    </div>
                    <div style="">
                        <a href="javascript:" class="btn btn-success btn-xs" v-on:click="openAvailability( t.cid )"> <b>Check Availability </b> </a>
                        <a href="javascript:" class="btn btn-default btn-xs" v-on:click="openProfile( t.cid )"><?php echo trans('general.view_profile') ?> </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="availabilityModal" class="modal fade" >
        <div class="modal-dialog modal-lg" style="width:90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo trans('general.availability') ?> </h4>
                </div>
                <div class="modal-body" id="calendar">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <div id="profileModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="pull-right">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    <h4 class="modal-title"><b><?php echo trans('general.teacher_profile') ?></b></h4>
                </div>
                <div class="modal-body">

                    <div class="col-lg-4">
                        <img src="" v-bind:src="teacher.profile_photo_url" class="img-responsive" />
                    </div>
                    <div class="col-lg-8">
                        <div>
                            <div class="pull-right">
                                <button class="btn btn-success" v-on:click="bookTeacher( teacher.id )"><i class="fa fa-plus"></i> <b><?php echo trans('general.schedule_me_a_class') ?></b> </button>
                            </div>
                            <h2>
                                <b>{{teacher.short_name}}</b>

                            </h2>
                        </div>
                        <div> {{ teacher.location }} </div>
                        <br />
                        <b>About</b>
                        <div style="border-top:1px solid #EEEEEE;margin-bottom:32px ">
                            {{ teacher.about }}
                        </div>
                        <b>Voice Demo</b>
                        <div style="border-top:1px solid #EEEEEE;margin-bottom:32px;padding-top:12px" >
                            <div v-bind:class="teacher.voice_url ? '' : 'hide' ">
                                <audio src="" id="audio_control" controls v-bind:src="teacher.voice_url"></audio>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <b><h2><?php echo trans('general.feedbacks') ?> </h2></b>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

     <div id="bookingModal" class="modal fade">
         <div class="modal-dialog">
             <form id="bForm">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h4 class="modal-title"><?php echo trans('general.book_a_class') ?></h4>
                 </div>
                 <div class="modal-body">

                     <div class="col-lg-6">
                         <div class="form-group">
                             <h4 id="class_date"></h4>
                         </div>
                         <div class="form-group">
                             <label for="start"><?php echo trans('general.start_time') ?> </label>
                             <select class="form-control" id="start_time" name="time">
                                 <option value="" v-for="t in time_select" :value="t.dt">{{t.dt}}</option>
                             </select>
                             <?php //echo \App\Models\ClassSessions\ClassSessionEntity::durationSelect();  ?>
                         </div>
                         <div class="form-group">
                             <label for="duration"><?php echo trans('general.duration') ?> </label>
                             <?php echo \App\Models\ClassSessions\ClassSessionEntity::durationSelect();  ?>
                         </div>
                     </div>
                     <div class="col-lg-6">
                         <div class="col-lg-6">
                            <img src="" :src="teacher.profile_photo_url" class="img-responsive" />
                         </div>
                         <div class="col-lg-6">
                             <h4 id="teacher_name">
                             </h4>
                             <i v-for="r in r( teacher.rating )" class="fa fa-star" style="color:#ffAA44"></i>
                         </div>
                     </div>
                     <div class="clearfix"></div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-primary" @click="confirmBooking()">Confirm</button>
                 </div>
             </div>
                 <?php echo csrf_field() ?>
                 <input type="hidden" name="teacher_id" id="teacher_id" value="" />
                 <input type="hidden" name="student_id" id="student_id" value="<?php echo \App\Models\Users\UserEntity::me()->id ?>" />
                 <input type="hidden" name="date" id="booking_date" value="" />
                 
             </form>
         </div>
     </div>        
</div>
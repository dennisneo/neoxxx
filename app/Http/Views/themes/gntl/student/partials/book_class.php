<div id="bcDiv">
    <div id="bookClassModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">
                        <?php echo trans('general.book_a_class') ?>
                        <span v-bind:class="teacher.id ? '' : 'hide' "> ( {{teacher.short_name}} ) </span>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning add_credit hide">
                        <div>
                            Sorry, you do not have enough credit to book a class. Click the button below to add more credits
                        </div>
                        <div>
                            <a href="<?php echo Url('student/credits/buy') ?>" class="btn btn-"><?php echo trans('general.buy_credits') ?></a>
                        </div>
                    </div>
                    <form id="sForm">
                        
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for=""><?php echo trans('general.date') ?> </label>
                                <div class="input-group">
                                    <?php echo \Form::text( 'date' , date('m/d/Y' , strtotime('tomorrow')) , [ 'class' => 'form-control' , 'id'=>'date' ,'style'=> 'position: relative; z-index: 100000;' ] ) ?>
                                    <span class="input-group-addon" id="basic-addon2">
                                    <a href="javascript:" v-on:click="showCalendar()"><i class="fa fa-calendar"></i></a>
                        </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6" >
                                <label for="time"><?php echo trans( 'general.preferred_start_time' ) ?></label><br />
                                <input type="text" id="time" data-format="h:mm a" data-template="hh : mm a" name="time">
                                <!--<input id="datetime12" data-format="DD-MM-YYYY h:mm a" data-template="hh : mm a" name="datetime" value="8:30 pm" type="text">-->
                                <?php //echo Helpers\DateTimeHelper::timeDropdown() ?>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="duration"><?php echo trans('general.duration') ?> </label>
                                <?php echo \Form::select( 'duration' , [ 20 => '20 min' , 40 => '40 min' ,  60 => '1 hr' ],'' , [ 'class' => 'form-control' , 'id'=>'duration' ] ) ?>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="dn"> <span style="color:white">.</span> </label>
                                <a href="javascript:" id="next" class="form-control btn btn-success btn-md" v-on:click="scheduleSession"> Next </a>
                            </div>
                        </div>
                        <?php echo csrf_field() ?>
                        <input type="hidden" name="student_id" id="student_id" value="<?php echo \App\Models\Users\UserEntity::me()->id ?>" />
                        <input type="hidden" name="teacher_id" id="teacher_id" value="{{teacher.id}}" />
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
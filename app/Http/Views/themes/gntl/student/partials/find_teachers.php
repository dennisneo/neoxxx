<div id="ftDiv">
    <div class="x_panel tile"  style="min-height:280px">
        <div class="x_title">
            <div class="pull-right">

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
                        <b>{{t.short_name}}</b>
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
                <div class="modal-body">
                    <table class="table table-striped">
                        <tr>
                            <th></th>
                            <?php foreach ( $next_seven_days as $v ) { ?>
                                <th><?php echo $v ?></th>
                            <?php } ?>
                        </tr>
                        <?php foreach ( $time_array as $v ) { ?>
                            <tr>
                                <td><?php echo $v ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                        
                    </table>
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
                                <button class="btn btn-success"><i class="fa fa-plus"></i> <b><?php echo trans('general.schedule_me_a_class') ?></b> </button>
                            </div>
                            <h2><b>{{teacher.short_name}}</b></h2>
                        </div>
                        <div> {{ teacher.location }} </div>
                        <br />
                        <b>About</b>
                        <div style="border-top:1px solid #EEEEEE;margin-bottom:32px ">
                            {{ teacher.about }}
                        </div>
                        <b>Voice Demo</b>
                        <div style="border-top:1px solid #EEEEEE;margin-bottom:32px ">

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
</div>
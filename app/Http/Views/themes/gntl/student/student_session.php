<div id="sDiv">
    <div class="row">
    <form id="sForm">
    <div class="col-lg-12">
        <div class="x_panel tile" style="">
            <div class="x_content">
                <div class="pull-right">
                    <a href="javascript:" class="btn btn-success save" v-on:click="saveSession()">
                        <i class="fa fa-check"></i> <b><?php echo trans('general.confirm') ?></b>
                    </a>
                    <a href="javascript:" class="btn btn-default" v-on:click="cancelSession()">
                        <i class="fa fa-times"></i> <?php echo trans('general.cancel') ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="x_panel tile" style="">
            <div class="x_title">
                <h2><?php echo trans('general.new_class_session') ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped">
                    <tr>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Duration</th>
                        <th>Credits</th>
                        <th>Teacher</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td><?php echo $cs->day ?></td>
                        <td><?php echo $cs->time ?></td>
                        <td><?php echo $cs->duration ?> mins </td>
                        <td><?php echo $cs->credits ?></td>
                        <td>{{ selected_teacher.short_name }}</td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <input type="hidden" name="cid" id="cid" value="<?php echo $cs->class_id ?>" />
    <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token() ?>" />

    </form>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="x_panel tile" style="min-height:520px">
                <div class="x_title">
                    <div class="pull-right">
                        <div class="form-group">
                            <label for="q"></label>
                            <?php echo \Form::text( 'q', '' , [ 'placeholder' => 'Search', 'class' => 'form-control' , 'id'=>'q' ] ) ?>
                        </div>
                    </div>
                    <h2><?php echo trans('general.choose_a_teacher') ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="loading"><i class="fa fa-refresh fa-spin"></i> <?php echo trans('searching_for_available_teachers'); ?></div>
                    <div class="row">
                        <div v-for="t in teachers" class="col-lg-4">
                            <div>
                                <img src="" v-bind:src="t.profile_photo_url" class="img-responsive">
                            </div>
                            <div>
                                <b>{{t.short_name}}</b>
                            </div>
                            <div style="text-align:center;">
                                <a href="javascript:" class="btn btn-success btn-xs" v-on:click="teacherSelected(t.id)">Select</a>
                                <a href="javascript:" class="btn btn-default btn-xs"><?php echo trans('general.view_profile') ?> </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                    <h2><?php echo trans('general.learning_goals') ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="x_panel tile" style="">
            <div class="x_content">
                <div class="pull-right">
                    <a href="javascript:" class="btn btn-success save" v-on:click="saveSession()">
                        <i class="fa fa-check"></i> <b><?php echo trans('general.confirm') ?></b>
                    </a>
                    <a href="javascript:" class="btn btn-default" v-on:click="cancelSession()">
                        <i class="fa fa-times"></i> <?php echo trans('general.cancel') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#datetime12').combodate(
            {
                customClass: 'date-control'
            }
        );
    });
</script>
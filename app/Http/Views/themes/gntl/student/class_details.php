<div id="sDiv">
    <div class="row">
    <form id="sForm">
    <div class="col-lg-12">

        <div class="alert alert-success" style="">
            <?php echo \App\Models\Settings\Settings::customMessageContent( 'message_new_class_session' ) ?>

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
                        <td><?php echo $cs->teacher_short_name ?></td>
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

    <div class="x_panel tile" style="">
        <div class="x_content">
            <div>
                <br />
                <a href="<?php echo Url('student/dashboard') ?>" class="btn btn-lg btn-primary"> Back to Dashboard </a>
            </div>
        </div>
    </div>
</div>


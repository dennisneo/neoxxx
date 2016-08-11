<div id="sDiv">
    <div class="row">
    <div class="col-lg-12">
        <div class="x_panel tile" style="">
            <div class="x_title">
                <h2><?php echo trans('general.new_class_session') ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped">
                    <tr>
                        <th>Time Schedule</th>
                        <th>Duration</th>
                        <th>Credits</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                    <h2><?php echo trans('general.choose_a_teacher') ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

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
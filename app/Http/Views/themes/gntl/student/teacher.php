<div id="sDiv">
    <div class="row">


        <div class="x_panel tile" style="">
            <div class="x_title">
                <div class="pull-right">
                    <button class="btn btn-success"> <b><?php echo trans('general.hire_teacher') ?></b>  </button>
                    <a href="<?php echo Url('student/teachers') ?>" class="btn btn-default"> < Back </a>
                </div>
                <h3><?php echo trans('general.teacher') ?></h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="col-lg-3" style="text-align:center ">
                    <img src="<?php echo $t->profile_photo_url ?>" class="img-responsive"/>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4">
                            <h3><b><?php echo $t->full_name ?></b></h3>
                        </div>
                        <div class="col-lg-8">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-8">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            Since:
                        </div>
                        <div class="col-lg-8">

                        </div>
                    </div>
                    <div class="row">
                        <h3><?php echo trans('general.feedbacks') ?></h3>
                        <hr />
                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>

</div>

<script>

</script>
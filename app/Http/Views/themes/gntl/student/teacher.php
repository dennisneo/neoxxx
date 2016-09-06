<div id="sDiv">
    <div class="row">


        <div class="x_panel tile" style="">
            <div class="x_title">
                <h2><?php echo trans('general.teachers') ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="col-lg-3" style=""  v-for="t in teachers">
                    <div class="">
                        <div>
                            <img src="" class="img-responsive" v-bind:src="t.profile_photo_url"/>
                        </div>
                        <div>
                            <a href="<?php echo Url('student/t/') ?>/{{t.cid}}">{{t.short_name}}</a>
                        </div>
                        <div>
                            Stars here
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>

</div>

<script>

</script>
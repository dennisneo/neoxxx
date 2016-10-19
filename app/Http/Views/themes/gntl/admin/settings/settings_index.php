<style>
    .padr{
        padding:8px
    }
</style>
<form id="sForm">
    <?php echo csrf_field(); ?>
<div id="sDiv">
    <div class=row" style="padding:24px 18px 18px 18px;">
        <br /><br />
        <div class="pull-right">
            <a href="javascript:" class="btn btn-success save" v-on:click="save"> Save </a>
        </div>
        <h3>Settings</h3>
    </div>

    <div class="x_panel panel-white">
		<div class="x_content">
            <h4><b>Credits</b></h4>
            <hr />
            <div class="row padr">
                <div class="col-lg-3"> Initial FREE Credits</div>
                <div class="col-lg-9">
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="settings_credits_free" id="credits_free" value="<?php echo $settings->credits_free ?>" />
                    </div>
                </div>
            </div>
            <div class="row padr">
                <div class="col-lg-3"> Credit Cost for 20 mins</div>
                <div class="col-lg-9">
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="settings_credits_twenty_minutes" id="credits_twenty_minutes" value="<?php //echo $settings->credits_twenty_minutes ?>" />
                    </div>
                </div>
            </div>
            <h4><b>Time Schedule</b></h4>
            <hr />
            <div class="row padr">
                <div class="col-lg-3"> Minimun time to register a class</div>
                <div class="col-lg-9">
                    <div class="col-lg-4">

                    </div>
                </div>
            </div>
		</div>

	</div>
    <div class="x_panel panel-white">
        <div class="x_content">
            <a href="javascript:" class="btn btn-success save" v-on:click="save"> Save </a>
        </div>
    </div>
</div>
</form>
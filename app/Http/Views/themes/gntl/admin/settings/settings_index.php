<style>
    .padr{
        padding:8px
    },

</style>
<div id="sDiv">
    <div class=row" style="padding:24px 18px 18px 18px;">
        <br /><br />
        <div class="pull-right">
            <a href="javascript:" class="btn btn-success save" v-on:click="save"> Save </a>
        </div>
        <h3>Settings</h3>
    </div>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#credits">Credits</a></li>
        <li><a data-toggle="tab" href="#messages">Custom Messages</a></li>
        <li><a data-toggle="tab" href="#rates">Salary Rates</a></li>
        <li><a data-toggle="tab" href="#schedules">Schedules</a></li>
    </ul>
    <div class="tab-content">
        <div id="credits" class="tab-pane fade in active">
            <?php echo view('admin.settings.settings_credits'); ?>
        </div>
        <div id="messages" class="tab-pane fade">
            <?php echo view('admin.settings.settings_messages' , compact('settings')); ?>
        </div>
        <div id="rates" class="tab-pane fade">
            <?php echo view('admin.settings.settings_rates' , compact('settings')); ?>
        </div>
        <div id="schedules" class="tab-pane fade">
            <?php echo view('admin.settings.settings_schedules'); ?>
        </div>
    </div>

    <div id="ccModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <form id="ccForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label for="credit">Credits</label>
                            <?php echo \Form::text( 'credits' , '' , [ 'class' => 'form-control fc' , 'id'=>'credits' ] ) ?>
                        </div>
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <?php echo \Form::text( 'cost' , '' , [ 'class' => 'form-control fc' , 'id'=>'cost' ] ) ?>
                        </div>
                        <div class="form-group">
                            <label for="desc">Description</label>
                            <?php echo \Form::textarea( 'desc' , '' , [ 'class' => 'form-control fc' , 'id'=>'desc' ] ) ?>
                        </div>
                    </div>
                </div>
                <?php echo csrf_field() ?>
                    <input type="hidden" name="cost_id" id="cost_id" value="" />
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save" v-on:click="saveCreditCost"> Save </button>
                </div>
            </div>
        </div>
    </div>
</div>
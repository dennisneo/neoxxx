<style>
    .padr{
        padding:8px
    }
</style>
<div id="sDiv">
<form id="sForm">
    <?php echo csrf_field(); ?>
    <div class=row" style="padding:24px 18px 18px 18px;">
        <br /><br />
        <div class="pull-right">
            <a href="javascript:" class="btn btn-success save" v-on:click="save"> Save </a>
        </div>
        <h3>Settings</h3>
    </div>

    <div class="x_panel panel-white">
		<div class="x_content">
            <div class="pull-right">
                <button class="btn btn-success btn-sm" v-on:click="openCreditCost"> Add Credit Cost</button>
            </div>
            <h4><b>Credits</b></h4>
            <hr />
            <div class="row padr">
                <ul class="list-group">
                    <li class="list-group-item row" v-for="cc in credits_cost | orderBy 'credits' ">
                        <div class="pull-right">
                            <a href="javascript:" v-on:click="editCreditCost(cc.cost_id)"><i class="fa fa-edit"></i></a>
                            <a href="javascript:" v-on:click="deleteCreditCost(cc.cost_id)"><i class="fa fa-trash"></i></a>
                        </div>
                        <div class="col-lg-3"> Credit {{cc.credits}} </div>
                        <div class="col-lg-3"> <b>${{cc.cost}} </b> </div>
                        <div class="col-lg-4"> {{cc.desc}} </div>

                    </li>
                </ul>
            </div>
		</div>

	</div>

    <div class="x_panel panel-white">
        <div class="x_content">
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
</form>

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
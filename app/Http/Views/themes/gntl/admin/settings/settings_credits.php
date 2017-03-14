<form id="sForm">
    <?php echo csrf_field(); ?>
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
</form>

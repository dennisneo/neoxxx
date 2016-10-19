<div id="lgDiv">
    <div class="x_panel tile" style="padding-bottom:60px">
        <div class="x_content">
            <div class=row" style="">
            <div class="pull-right">
                <button class="btn btn-primary" v-on:click="add()"> Add New </button>
            </div>
            <h3><b>Learning Goals</b></h3>
    </div>
            <div class="row">
        <table class="table table-striped">
            <tr>
                <th></th>
                <th>Learning Goals</th>
                <th></th>
            </tr>
            <tr v-for="g in goals">
                <td></td>
                <td><b>{{g.goal}}</b>
                    <div style="">
                        <i>{{g.summary}}</i>
                    </div>
                </td>
                <td style="width:144px">
                    <div class="btn-group">
                        <button class="btn btn-default btn-sm" v-on:click="edit( g.goal_id )"> <i class="fa fa-edit"></i> Edit</button>
                        <button class="btn btn-default btn-sm" v-on:click="remove( g.goal_id )"> <i class="fa fa-trash-o"></i> Delete </button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
        </div>
    </div>
    <div id="lgdiv" class="modal fade" style="z-index:99999999">
        <div class="modal-dialog">

            <form id="lForm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"> </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="learning-goal">Learning Goal</label>
                        <?php //echo \Form::text( 'goal' , '{{goal.goal}}' , [ 'class' => 'form-control lg-field' , 'id'=>'goal' ] ) ?>
                        <input type="text" name="goal" id="goal" value="{{lg.goal}}" class="form-control lg-field" />
                    </div>
                    <div class="form-group">
                        <label for="summary">Summary</label>
                        <?php echo \Form::textarea( 'summary' , '{{lg.summary}}' , [ 'class' => 'form-control lg-field' , 'id'=>'summary' ] ) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:" class="btn btn-primary" v-on:click="saveGoal()">Save</a>
                </div>

                <input type="hidden" name="goal_id" class="lg-field" id="goal_id" value="{{lg.goal_id}}" />
                <?php echo csrf_field(); ?>
            </div>
            </form>
        </div>
    </div>
</div>

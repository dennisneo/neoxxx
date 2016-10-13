<style>
    table tr td{
        padding: 4px;
        vertical-align: top;
        font-size: 1em;
    }
</style>

<div id="rDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <div class="pull-right">
                    <button class="btn btn-success" v-on:click="newRecord()"> <i class="fa fa-plus"></i> <b>New</b></button>
                </div>
                <h3><b>Performance Records</b></h3>
                <br />
                <table class="table table-striped">
                    <tr>
                        <th>Date Occurred</th>
                        <th>Teacher</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Warnings</th>
                        <th>Status</th>
                    </tr>
                    <tr v-for="r in records">
                        <td>{{r.occurred_at}}</td>
                        <td>{{r.teacher_name}}</td>
                        <td>{{r.type}}</td>
                        <td>{{r.description}}</td>
                        <td>{{r.warnings}}</td>
                        <td>{{r.status}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div id="performanceModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Performance Record</h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <form id="pForm">
                            <div class="form-group">
                                <label for="teacher">Teacher</label>
                                <?php echo \Form::text( 'teacher' , '' , [ 'class' => 'form-control' , 'id'=>'teacher' ] ) ?>
                                <input type="hidden" name="teacher_id" id="teacher_id" value="" />
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <?php echo \Form::text( 'type' , '' , [ 'class' => 'form-control' , 'id'=>'type' ] ) ?>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <?php echo \Form::textarea( 'description' , '' , [ 'class' => 'form-control' ,
                                    'id'=>'description' , 'style' => 'height:100px' ] ) ?>
                            </div>
                            <div class="form-group">
                                <label for="date_of_occurence">Date of Occurence</label>
                                <?php echo \Form::text( 'date_of_occurence' , '' , [ 'class' => 'form-control' , 'id'=>'date_of_occurence' ] ) ?>
                            </div>
                            <div class="form-group" >
                                <label for="warning">Warnings</label>
                                <?php echo \Form::select( 'warnings', [1,2,3,4,5],  '' , [ 'class' => 'form-control' , 'id'=>'warnings' ] ) ?>
                            </div>
                            <div>
                                <a href="javascript:" v-on:click="savePerformanceRecord()" type="button" class="btn btn-primary">Save</a>
                            </div>
                            <input type="hidden" name="teacher_id" class="teacher_id" value="" />
                            <?php echo csrf_field(); ?>

                        </form>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>


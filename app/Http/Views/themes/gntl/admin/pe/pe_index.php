<div id="peDiv">
    <div class=row" style="padding:24px 18px 18px 18px;">
        <br /><br />
        <div class="pull-right">
            <a href="<?php echo Url('admin/pe/q') ?>" class="btn btn-primary"> Add New Question </a>
        </div>
        <h3>Placement Exam Questionaire</h3>
    </div>
    <div class="x_panel panel-white">
        <div class="x_content">
            <div class="row">
                <table class="table table-striped">
                    <tr class="loading">
                        <td colspan="2">
                            <i class="fa fa-refresh fa-spin"></i> Loading...
                        </td>
                    </tr>
                    <tr v-for="q in questions ">
                        <td>{{q.question}}
                            <br /><br />
                            <div style="padding-left:36px">
                                <b>Answer Choices</b>
                                <table class="table">
                                    <tr v-for="c in choices[q.q_id]">
                                        <td>{{c.choice}}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="btn-group">
                                <a href="<?php echo Url('admin/pe/q') ?>?qid={{q.q_id}}" class="btn btn-default btn-sm"> <i class="fa fa-edit"></i> Edit</a>
                                <button class="btn btn-default btn-sm" v-on:click="remove( q.q_id )"> <i class="fa fa-trash-o"></i> Delete </button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div id="pediv" class="modal fade" style="z-index:99999999">
        <div class="modal-dialog">

            <form id="lForm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"> {{ question.q_id ? 'Edit' : 'Add' }} Question</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <a href="javascript:" class="btn btn-primary" v-on:click="saveGoal()">Save</a>
                </div>
                <input type="hidden" name="q_id" class="pe-field" id="q_id" value="{{question.q_id}}" />
                <?php echo csrf_field(); ?>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="qDiv">
    <div class="x_panel tile" style="padding-bottom:60px">
        <div class="x_content">
            <div class=row">
                <div class="pull-right">
                    <a href="javascript:" class="btn btn-primary" v-on:click="saveQuestion()"> Save </a>
                </div>
                <h3>Question</h3>

            </div>
            <form method="post" id="pForm">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="form-group">
                    <label for="question">Question</label>
                    <?php echo \Form::textarea( 'question' , '' , [ 'class' => 'form-control' , 'id'=>'', 'style' => 'height:120px' ] ) ?>
                </div>

                <div class="form-group col-lg-8">
                    <label for="choices"> Choices </label>
                    <div class="input-group">
                          <?php echo \Form::text( 'choice' , '' , [ 'class' => 'form-control' , 'id'=>'choice' ] ) ?>
                          <span class="input-group-btn">
                                <a href="javascript:" class="btn btn-success" type="button" v-on:click="addChoice()">Add a Choice</a>
                          </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <table class="table table-striped">
                    <tr>
                        <th style="width:64px "> Answer</th>
                        <th style="text-align: left;padding-left:64px;width:70%"> Choices </th>
                        <th></th>
                    </tr>
                    <tr v-for="c in choices">
                        <td><input type="radio" name="answer" value="{{$index}}" id="" /></td>
                        <td>
                            <div class="c-group-text" id="div-text-{{$index}}">{{ c.choice }}</div>
                            <div class="input-group c-group hide" id="div-{{$index}}">
                                <input type="text" name="c[{{$index}}]" value="{{ c.choice }}" class="form-control c-input"
                                       id="input-{{$index}}" data-idx="{{$index}}" v-on:keyup.13="saveChoice($index)" />
                                <span class="input-group-btn">
                                    <a href="javascript:" class="btn btn-success" type="button" v-on:click="saveChoice($index)"><i class="fa fa-check"></i></a>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="javascript:" class="btn btn-default btn-sm" v-on:click="editChoice($index)"><i class="fa fa-edit"></i> Edit</a>
                                <a href="javascript:" class="btn btn-default btn-sm" v-on:click="removeChoice($index)"><i class="fa fa-trash-o"></i> Delete</a>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="row">
                    <div class="form-group col-lg-12">
                        <a href="javascript:" class="btn btn-primary" v-on:click="saveQuestion()"> Save </a>
                    </div>
                </div>
            </div>

            </form>
        </div>
    </div>

    <div id="aModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edit</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="choice"></label>
                        <?php echo \Form::text( 'edit_choice' , '' , [ 'class' => 'form-control' , 'id'=>'edit_choice' ] ) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>

            </div>
        </div>
    </div>
</div>

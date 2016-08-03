<div id="qDiv">
    <div class=row" style="padding:24px 18px 18px 18px;">
        <br /><br />
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
                    <a href="javascript:" class="btn btn-primary" type="button" v-on:click="addChoice(  )">Add a Choice</a>
                  </span>
            </div>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped">
            <tr>
                <th style="width:64px "> Answer</th>
                <th style="text-align: left;padding-left:64px"> Choices </th>
                <th></th>
            </tr>
            <tr v-for="c in choices">
                <td><input type="radio" name="answer" value="{{ c.choice }}" id="" /></td>
                <td>
                    {{ c.choice }}
                </td>
                <td>
                    <div class="btn-group">
                        <a href="javascript:" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <a href="javascript:" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i> Delete</a>
                    </div>
                </td>
            </tr>
        </table>
        <div class="row">
            <div class="form-group col-lg-12">
                <a href="javascript:" class="btn btn-primary btn-sm" v-on:click="saveQuestion()"> Save </a>
            </div>
        </div>
    </div>

    </form>

</div>

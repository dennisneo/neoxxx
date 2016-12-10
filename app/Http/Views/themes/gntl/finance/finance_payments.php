<div id="fDiv">
    <div class="x_panel tile"  style="">
        <div class="x_title">
            <div class="pull-right" style="">
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="col-lg-3">
                            Date From: <?php echo \Form::text( 'date_from' , '' , [ 'class' => 'form-control inline' , 'id'=>'date_from' ] ) ?>
                        </div>
                        <div class="col-lg-3">
                            Date To: <?php echo \Form::text( 'date_to' , '' , [ 'class' => 'form-control inline' , 'id'=>'date_to' ] ) ?>
                        </div>
                        <div class="col-lg-3">
                            &nbsp;<br />
                            <a href="javascript:" class="btn btn-primary" v-on:click="show()"> Show </a>
                        </div>
                    </div>
                </div>

            </div>
            <h2>Finance Dashboard</h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped">
                <tr>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Student Name</th>
                    <th>Credits</th>
                    <th>Date</th>
                </tr>
                <tr v-for="p in payments">
                    <td>{{p.transaction_code}}</td>
                    <td>{{p.amount}}</td>
                    <td>{{p.last_name}}, {{p.first_name}}</td>
                    <td>{{p.credits}}</td>
                    <td>{{p.paid_at}}</td>
                </tr>
            </table>
        </div>

    </div>
</div>


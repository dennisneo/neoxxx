<div id="pDiv" style="" v-cloak>
    <div class="x_panel tile" style="">
        <div class="x_header">
            <form id="pForm">
            <div class="row">
                <div class="col-lg-4">
                    <h3> Payment History </h3>
                </div>
                <div class="col-lg-8">
                    <div class="col-lg-2">

                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text" name="from" value="" id="from" class="form-control" placeholder="From" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text" name="to" value="" id="to" class="form-control" placeholder="To" />
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <a href="javascript:" class="btn btn-primary" @click="filter"> Filter </a>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-lg-8">
                    <table class="table">
                        <tr>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Credits</th>
                            <th>Date</th>
                        </tr>
                        <tr v-show="!payments.length && !loading">
                            <td colspan="4">No Payments Found</td>
                        </tr>
                        <tr v-show="!payments.length && loading">
                            <td colspan="4"><i class="fa fa-spin fa-refresh"></i> Loading</td>
                        </tr>

                        <tr v-for="p in payments">
                            <td>{{p.student_name}}</td>
                            <td>$ {{p.amount}}</td>
                            <td>{{p.credits}}</td>
                            <td>{{p.paid_at}}</td>
                        </tr>

                    </table>
                </div>
                
                <div class="col-lg-4">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <table class="table table-striped">
                                <tr>
                                    <th>Total Amouunt:</th>
                                    <td>$ {{total_amount}}</td>
                                </tr>
                                <tr>
                                    <th>Total Entries:</th>
                                    <td>{{total_entries}}</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</div>


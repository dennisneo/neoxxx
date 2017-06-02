<div id="sDiv" v-cloak>
    <div class="x_panel tile" style="">
        <div class="x_header">
            <form id="pForm">
            <div class="row">
                <div class="col-lg-4">
                    <h3> Salary History </h3>
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
                <div class="col-lg-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Teacher</th>
                            <th>Date Coverage</th>
                            <th>Total Minutes</th>
                            <th>Total Amount</th>
                            <th></th>
                        </tr>
                        <tr v-for="s in salaries">
                            <td> {{ s.teacher.full_name }} </td>
                            <td> {{ s.date_coverage }} </td>
                            <td> {{ s.total_minutes }} </td>
                            <td> $ {{ s.total_income }} </td>
                            <td>
                                    <div class="dropdown pull-right">
                                        <i style="cursor: pointer" class="fa fa-bars dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
                                        <ul class="dropdown-menu" style="padding:12px;font-size: 1em">
                                            <li><a href="javascript:" @click="openDaily( s.salary_history_id )"> <i class="fa fa-edit"></i> View Daily </a></li>
                                        </ul>
                                    </div>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
        </div>
    </div>

    <div id="dailyModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"> {{ salary.teacher ? salary.teacher.full_name+' ( '+salary.date_coverage+' ) '  : '' }} </h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Date</th>
                            <th>Total Time</th>
                            <th>Earnings</th>
                        </tr>
                        <tr v-for="dd in daily_data">
                            <td> {{ dd.salary_date }} </td>
                            <td> {{ dd.total_time }} </td>
                            <td> $ {{ dd.day_income }} </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


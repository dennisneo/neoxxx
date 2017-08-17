<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div id="sDiv" v-cloak>
    <div class="x_panel tile" style="">
        <div class="x_header">
            <form id="pForm">
            <div class="row">
                <div class="col-lg-4">
                    <h3> Salary History </h3>
                </div>
                <div class="col-lg-8">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="padding:4px;margin:2px;margin-bottom:12px;background-color: #EFEFEF">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label style="font-weight: normal"> From </label>
                            <input type="text" name="from" value="" id="from" class="form-control" placeholder="From" />
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label style="font-weight: normal"> To </label>
                            <input type="text" name="to" value="" id="to" class="form-control" placeholder="To" />
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="student" style="font-weight: normal"> Teacher</label>
                            <input type="text" name="teacher" value="" id="teacher" class="form-control" />
                        </div>

                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="student" style="font-weight: normal"> Teacher type</label>
                            <select name="teacher_type" class="form-control">
                                <option value="0"> All </option>
                                <option value="native"> Native </option>
                                <option value="local"> Local </option>
                                <option value="filipino"> Filipino </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <label style="font-weight: normal"> &nbsp;</label>
                        <input type="hidden" name="teacher_id" id="teacher_id" value="" />
                        <a href="javascript:" class="btn btn-primary form-control" @click="filter" > Filter </a>
                        <a href="javascript:" @click=" more_search_options = ! more_search_options" >
                            {{ more_search_options ? 'Less Options' : 'More Options' }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row" v-show="more_search_options">
                <div class="col-lg-12" style="padding:4px;margin:2px;margin-bottom:12px;background-color: #EFEFEF">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label style="font-weight: normal"> Salary Amount From </label>
                            <input type="text" name="salary_from" value="" id="salary_from" class="form-control" placeholder="From" />
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label style="font-weight: normal"> Salary Amount To </label>
                            <input type="text" name="salary_to" value="" id="salary_to" class="form-control" placeholder="To" />
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped">
                        <tr style="background-color: #FFFFFF">
                            <th>Teacher</th>
                            <th>Date Coverage</th>
                            <th>Total Minutes</th>
                            <th>Total Amount</th>
                            <th></th>
                        </tr>
                        <tr v-show="!salaries.length && !loading">
                           <td colspan="5"> <b>No record found </b> </td>
                        </tr>
                        <tr v-show="loading">
                            <td colspan="5"> <i class="fa fa-spin fa-refresh"></i> Searching... </td>
                        </tr>
                        <tbody>
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
                        </tbody>
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


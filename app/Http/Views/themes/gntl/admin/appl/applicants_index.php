<div id="aDiv">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class=row">
                <div class="col-lg-6">
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6" style="border: 0;padding:0;margin:0">
                            <input type="text" class="form-control form-inline" style="display: inline" name="q" id="q" @keydown="qClick" />
                        </div>
                        <div class="col-lg-3" style="border: 0;padding:0;margin:0">
                            <select name="status" id="status" style="display: inline" class="form-control">
                                <option value="0"> All </option>
                                <option value="new"> New </option>
                                <option value="archived"> Archived </option>
                            </select>
                        </div>
                        <div class="col-lg-3" style="border: 0;padding:0;margin:0>
                            <span class="input-group-btn" style="display: inline"><button class="btn btn-default" @click="searchApplicants" id="searchButton"><i class="fa fa-search"></i> Search</button></span>
                        </div>
                        </div>
                    </div>
                </div>

            <h3> <b>Teaching Applicants</b> </h3>
            </div>
            <div class="row">
        <table class="table table-striped">
            <tr>
                <th style="width: 48px"></th>
                <th> Name </th>
                <th> Status </th>
                <th> Applied At</th>
                <th></th>
            </tr>
            <tr class="loading">
                <td colspan="3">
                    <i class="fa fa-refresh fa-spin"></i> Loading...
                </td>
            </tr>
            <tr class="loading">
                <td colspan="3">

                </td>
            </tr>
            <tr v-for="a in applicants">
                <td></td>
                <td>
                    {{ a.last_name }}, {{ a.first_name }}
                </td>
                <td> {{ a.status }} </td>
                <td> {{ a.created_at }} </td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo Url('admin/applicant') ?>/{{ a.id }}" class="btn btn-default btn-sm"> <i class="fa fa-edit"></i> Manage</a>
                    </div>
                </td>
            </tr>
        </table>
    </div>
        </div>
    </div>
    <div id="aModalDiv" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-6">
                        <table class="">
                            <tr>
                                <td>Name:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Country:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Age:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Gender:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Experience</b></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <div>
                            <b> Status: </b>
                            <div>
                                Requirements:
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</div>

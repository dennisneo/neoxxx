
<div id="sDiv">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
        <div class="col-lg-8">
            <h3> <b>Students</b> </h3>
        </div>
        <div class="col-lg-4" style="">
            <div class="input-group">
                <input type="text" id="q" v-model="q" class="form-control" />
                <span class="input-group-btn"><button class="btn btn-default"> <i class="fa fa-search"></i> Search</button></span>
            </div>
        </div>

    </div>
        <div class="row">
        <table class="table table-striped">
            <tr>
                <th style="width: 48px"></th>
                <th> Name </th>
                <th> Status </th>
                <th></th>
            </tr>
            <tr class="loading" v-bind:class=" students.length > 0 ? 'hide' : 'show' ">
                <td colspan="4">
                    <i class="fa fa-refresh fa-spin"></i> Loading...
                </td>


            </tr>
            <tr class="loading" v-bind:class=" students.length > 0 ? 'hide' : 'show' ">
                <td colspan="4">

                </td>
            </tr>
            <tr v-for="s in students">
                <td><img src="" style="width:64px" v-bind:src="t.profile_photo_url"/></td>
                <td style="">
                    {{ s.full_name }}
                </td>
                <td> {{ s.status }} </td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo Url('admin/student') ?>/{{ s.id }}" class="btn btn-default btn-sm"> <i class="fa fa-edit"></i> Manage</a>
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

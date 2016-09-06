<style>
    td{

    }
</style>
<div id="tDiv">
    <div class="row">
        <div class="col-lg-8">
            <h3> Teachers </h3>
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
            <tr class="loading" v-bind:class=" teachers.length > 0 ? 'hide' : 'show' ">
                <td colspan="5">
                    <i class="fa fa-refresh fa-spin"></i> Loading...
                </td>
            </tr>
            <tr class="loading" v-bind:class=" teachers.length > 0 ? 'hide' : 'show' ">
                <td colspan="5">

                </td>
            </tr>
            <tr v-for="t in teachers | filterBy q ">
                <td><img src="" style="width:64px" v-bind:src="t.profile_photo_url"/></td>
                <td style="">{{ t.full_name }}</td>
                <td> {{ t.status }} </td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo Url('admin/teacher') ?>/{{ t.id }}" class="btn btn-default btn-sm"> <i class="fa fa-edit"></i></a>
                    </div>
                </td>
            </tr>
        </table>
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

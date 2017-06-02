<div id="tDiv">
    <div class="x_panel tile" style="padding-bottom:60px">
        <div class="x_content">
            <div class="row">
                <div class="col-lg-8">
                    <h3><b> Teachers </b></h3>
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
                    <thead>
                    <tr>
                        <th style="width: 48px"></th>
                        <th> Name </th>
                        <th> Type </th>
                        <th> Since </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tr class="loading" v-bind:class=" teachers.length > 0 ? 'hide' : 'show' ">
                        <td colspan="5">
                            <i class="fa fa-refresh fa-spin"></i> Loading...
                        </td>
                    </tr>
                    <tbody>
                    <tr v-for="t in teachers">
                        <td><img src="" style="width:64px" v-bind:src="t.profile_photo_url"/></td>
                        <td style="">
                            <b>{{ t.full_name }}</b><br />
                            {{ t.location }}
                        </td>
                        <td> {{ t.type }} </td>
                        <td> {{ t.created_at }} </td>
                        <td>
                            <div class="btn-group">
                                <div class="dropdown pull-right" >
                                    <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" style="padding:12px;font-size: 1em">
                                        <li><a href="<?php echo Url('admin/teacher') ?>/{{ t.id }}"> <i class="fa fa-edit"></i> View / Edit</a></li>
                                        <li><a href="javascript:" @click="openPerformanceRecord( t.id ) "> <i class="fa fa-bar-chart-o"></i> Performance Record </a></li>
                                        <li><a href="<?php echo Url('admin/teacher/schedule') ?>/{{ t.id }}"> <i class="fa fa-calendar"></i> Set Schedule </a></li>
                                        <li><a href="javascript:" v-on:click="openSettings( t.id )"> <i class="fa fa-gear"></i> Settings </a></li>
                                        <li><a href="javascript:" v-on:click="openNotificationModal( t.id )"> <i class="fa fa-comment"></i> Send Message </a></li>
                                    </ul>
                                </div>

                            </div>
                        </td>
                    </tr>

                    </tbody>
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

    <div id="settingsModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{teacher.full_name}}</h4>
                </div>
                <div class="modal-body">
                    <form id="settingsForm">
                    <div class="form-group">
                        <label for="rate">Rate per Hour in $</label>
                        <?php echo \Form::text( 'rate' , '{{teacher.rate_per_hr}}' , [ 'class' => 'form-control' , 'id'=>'rate' ] ) ?>
                    </div>
                    <?php echo csrf_field() ?>
                    <input type="hidden" name="teacher_id" id="teacher_id" value="{{teacher.id}}" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" v-on:click="saveSettings" >Save Settings</button>
                </div>
            </div>
        </div>
    </div>

    <div id="performanceModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"> <b>Performance Records </b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4><b> {{ teacher.last_name }}, {{teacher.first_name }} </b></h4>
                            <table class="table table-striped">
                                <tr>
                                    <th>Date Occurred</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Warnings</th>
                                    <th>Status</th>
                                </tr>
                                <tr v-show=" ! records.length && ! records_loading ">
                                    <td colspan="5"> No record found</td>
                                </tr>
                                <tr v-show=" ! records.length && ! records_loading ">
                                    <td colspan="5"> </td>
                                </tr>
                                <tr v-for="r in records ">
                                    <td>{{ r.occurred_at }}</td>
                                    <td>{{ r.type}}</td>
                                    <td>{{ r.description}}</td>
                                    <td>{{ r.warnings}}</td>
                                    <td>{{ r.status}}</td>
                                </tr>
                            </table>
                            <div v-show="records_loading">
                                <i class="fa fa-spin fa-refresh"></i> Loading...
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>

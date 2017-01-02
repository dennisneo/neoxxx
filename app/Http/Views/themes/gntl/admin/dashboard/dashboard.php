

<div class="x_panel tile" style="">
    <div class="x_content">
        <div class="row">
            <h3><b>Admin Dashboard</b></h3>
            <div id="chart4" class='with-3d-shadow with-transitions col-lg-12'>
                <svg class="" height="360"></svg>
            </div>
        </div>
    </div>
</div>

<div id="dDiv">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Latest Teaching Applicants</h3>
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Date Applied</th>
                        </tr>
                        <tr v-for="a in applicants">
                            <td>{{a.last_name}}, {{a.first_name}}</td>
                            <td>{{a.created_at}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <h3>Latest Registered Students</h3>
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Signup Date</th>
                        </tr>
                        <tr v-for="a in students">
                            <td>{{a.last_name}}, {{a.first_name}}</td>
                            <td>{{a.created_at}}</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Upcoming Class Sessions</h3>
                    <table class="table table-striped">
                        <tr>
                            <th>Student</th>
                            <th>Teacher</th>
                            <th>Duration</th>
                            <th>Date Time</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <h3>Messages</h3>
                    <table class="table table-striped">
                        <tr>
                            <th></th>
                            <th>Message</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Daily Registration Chart</h3>
                </div>
            </div>
        </div>
    </div>
</div>

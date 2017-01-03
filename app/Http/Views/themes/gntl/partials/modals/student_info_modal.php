<div id="studentInfoModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Student Info</h4>
            </div>
            <div class="modal-body">
                <div>
                    <b>Personal and Contact Info</b>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table" style="margin-top: 24px">
                            <tr>
                                <td>Name:</td>
                                <td class="hl">{{ student.full_name }}</td>
                            </tr>
                            <tr>
                                <td>Gender:</td>
                                <td class="hl">{{ student.gender }}</td>
                            </tr>
                            <tr>
                                <td>Age:</td>
                                <td class="hl"></td>
                            </tr>
                            <tr>
                                <td>Location:</td>
                                <td class="hl">{{ student.location }}</td>
                            </tr>
                            <tr>
                                <td> Timezone: </td>
                                <td class="hl"> {{ student.timezone }} </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="table" style="margin-top: 24px">
                            <tr>
                                <td>Skype ID:</td>
                                <td class="hl"> {{ student.skype }}</td>
                            </tr>
                            <tr>
                                <td>QQ ID:</td>
                                <td class="hl">{{ student.qq }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td class="hl">{{ student.email }}</td>
                            </tr>
                            <tr>
                                <td>Mobile Phone:</td>
                                <td class="hl"> {{ student.mobile }} </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="hl"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <b>Class Details</b>
                <table class="table" style="margin-top: 24px">
                    <tr>
                        <td>Learning Purpose:</td>
                        <td class="">
                            <ul>
                                <li :class="learning_info.length ? 'hide' : '' "> No learning purpose found </li>
                                <li v-for="l in learning_info">{{ l.goal }}</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Materials / Textbooks:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Message from Student:</td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>


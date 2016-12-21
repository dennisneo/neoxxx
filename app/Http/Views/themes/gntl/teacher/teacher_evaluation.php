<style>

</style>

<div id="eDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <h3><b>Student's Evaluation</b></h3>
                <br />
                <table class="table table-striped">
                    <tr>
                        <th>Student Name</th>
                        <th>Degree Satisfaction</th>
                        <th>Internet Quality</th>
                        <th>Pronunciation</th>
                        <th>Teaching Skills</th>
                        <th>Date</th>
                    </tr>
                    <tr :class=" feedbacks.length ? 'hide' : '' ">
                        <td colspan="6"> <?php echo trans('general.no_record_found') ?> </td>
                    </tr>
                    <tr :class=" feedbacks.length ? 'hide' : '' ">
                        <td colspan="6"></td>
                    </tr>
                    <tr v-for="f in feedbacks">
                        <td>{{ f.student_short_name }}</td>
                        <td><i v-for="r in f.satisfaction" class="fa fa-star" style="color:#ffAA44"></i></td>
                        <td><i v-for="r in f.internet_quality" class="fa fa-star" style="color:#ffAA44"></i></td>
                        <td><i v-for="r in f.pronunciation" class="fa fa-star" style="color:#ffAA44"></i></td>
                        <td><i v-for="r in f.teaching_skills" class="fa fa-star" style="color:#ffAA44"></i></td>
                        <td>{{ f.added_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo \App\Models\Users\UserEntity::me()->id ?>" />
</div>


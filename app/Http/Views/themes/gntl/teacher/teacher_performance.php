<style>

</style>

<div id="tDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo $teacher->id  ?>" />
                <h3><b>Performance</b></h3>
                <br />
                <table class="table table-striped">
                    <tr>
                        <th>Date of Occurrence</th>
                        <th>Recorded Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Appeal</th>
                    </tr>
                    <tr :class=" records.length ? 'hide' : '' ">
                        <td colspan="6"> <?php echo trans('general.no_record_found') ?> </td>
                    </tr>

                    <tr v-for="r in records">
                        <td>{{r.occurred_at}}</td>
                        <td>{{r.recorded_at}}</td>
                        <td>{{r.type}}</td>
                        <td>{{r.description}}</td>
                        <td></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>


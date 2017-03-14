<style>

</style>

<div id="tDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <h3><b>Salary History</b></h3>
                <br />
                <table class="table table-striped">
                    <tr>
                        <th>Date Covered</th>
                        <th>Amount</th>
                        <th></th>

                    </tr>
                    <tr :class="records.length ? 'hide' : '' ">
                        <td colspan="5"> <?php echo trans('general.no_record_found') ?> </td>
                    </tr>
                    <tr :class=" records.length ? 'hide' : '' ">
                        <td colspan="5"></td>
                    </tr>
                    <tr v-for="r in records">
                        <td>{{ r.week_from }} to {{ r.week_to }}</td>
                        <td>$ {{ r.total_income }}</td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="row">
                <h3><b>Transaction History</b></h3>
                <br />
                <table class="table table-striped">
                    <tr>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Balance</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo $teacher->id ?>" />
</div>


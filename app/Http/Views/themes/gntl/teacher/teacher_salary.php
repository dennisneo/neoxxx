<style>

</style>

<div id="tDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
                <h3><b>Salary</b></h3>
                <br />
                <table class="table table-striped">
                    <tr>
                        <th>Date Covered</th>
                        <th>Amount Due</th>
                        <th></th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                    <tr :class=" salary_records.length ? 'hide' : '' ">
                        <td colspan="5"> <?php echo trans('general.no_record_found') ?> </td>
                    </tr>
                    <tr :class=" salary_records.length ? 'hide' : '' ">
                        <td colspan="5"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>


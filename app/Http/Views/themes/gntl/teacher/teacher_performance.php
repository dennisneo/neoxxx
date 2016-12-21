<style>

</style>

<div id="tDiv" style="">
    <div class="x_panel tile" style="">
        <div class="x_content">
            <div class="row">
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
                    <tr :class=" records.length ? 'hide' : '' ">
                        <td colspan="6"></td>
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


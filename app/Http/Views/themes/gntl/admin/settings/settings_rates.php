<form id="ratesForm">
    <?php echo csrf_field() ?>
    <div class="x_panel panel-white">
        <div class="x_content">
            <h4><b>Salary Rates per Hour</b></h4>
            <hr />
            <div class="row padr">
                <div class="col-lg-2"> Native ( $ ):</div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="">From</label>
                        <select name="rate_native_from" class="form-control">
                            <option value="" v-for="r in rates" :value="r"> {{r}} </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label for="">To</label>
                    <select name="rate_native_from" class="form-control">
                        <option value="" v-for="r in rates" :value="r"> {{r}} </option>
                    </select>
                </div>

            </div>
            <div class="row padr">
                <div class="col-lg-2"> Local ( $ ):</div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="">From</label>
                        <select name="rate_local_from" class="form-control">
                            <option value="" v-for="r in rates" :value="r"> {{r}} </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label for="">To</label>
                    <select name="rate_local_to" class="form-control">
                        <option value="" v-for="r in rates" :value="r"> {{r}} </option>
                    </select>
                </div>
            </div>
            <div class="row padr">
                <div class="col-lg-2"> Filipino ( $ ):</div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="">From</label>
                        <select name="rate_filipino_from" class="form-control">
                            <option value="" v-for="r in rates" :value="r"> {{r}} </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <label for="">To</label>
                    <select name="rate_filipino_to" class="form-control">
                        <option value="" v-for="r in rates" :value="r"> {{r}} </option>
                    </select>
                </div>
            </div>
        </div>
        <div>
            <a href="javascript:" class="btn btn-success save" @click="saveSalaryRate"> Save </a>
        </div>
    </div>
</form>



<form id="mForm">
    <?php echo csrf_field() ?>
    <div class="x_panel panel-white">
        <div class="x_content">
            <h4><b>Custom Messages</b></h4>
            <hr />
            <div class="row padr">
                <?php foreach ( $settings as $s ) { ?>
                    <?php if( substr( $s->skey , 0 , 7 ) == 'message' ){ ?>
                        <div class="row" style="margin-bottom:24px">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for=""><?php echo  $s->customMessageText(); ?></label>
                                    <textarea class="col-lg-12" name="<?php echo $s->skey ?>" style="min-height: 120px"><?php echo $s->value ?></textarea>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="row">
                <a href="javascript:" class="btn btn-success save_message" @click="saveMessage"> Save </a>
            </div>
        </div>
    </div>
</form>


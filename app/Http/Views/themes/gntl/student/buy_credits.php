
<div id="bDiv" class="x_panel tile" style="min-height:280px;" >
    <div class="x_title">
        <h2>Buy Credits</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="col-md-3 col-sm-6 col-xs-12" v-for="cc in credits_cost | orderBy 'credits' " >
            <div class="pricing">
                <div class="title" style="margin:6px">
                    <h2><b>{{cc.credits}} Credits</b></h2>
                    <h1>${{cc.cost}}</h1>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="pricing_features">
                            {{ cc.desc }}
                        </div>
                    </div>
                    <div class="pricing_footer">
                        <a href="{{cc.payment_url}}"  class="btn btn-success btn-block" role="button"> <b>BUY</b> <span> </span></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <form id="cForm">
        <input type="hidden" name="sid" id="sid" value="<?php echo Helpers\Text::convertInt( \App\Models\Users\UserEntity::me()->id ); ?>" />
        <input type="hidden" name="cost_id" id="cost_id" value="" />
        <input type="hidden" name="amount" id="amount" value="0" />
        <input type="hidden" name="member_id" id="member_id" value="<?php echo \App\Models\Users\UserEntity::me()->id ?>" />
        <?php echo csrf_field() ?>
    </form>
</div>
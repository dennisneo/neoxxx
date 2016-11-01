
<div id="bDiv" class="x_panel tile" style="min-height:280px;" >
    <div class="x_title">
        <h2>Buy Credits</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="pricing">
                <div class="title" style="margin:6px">
                    <h2><b>20 Credits</b></h2>
                    <h1>$15</h1>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="pricing_features">
                            <ul class="list-unstyled text-left">
                                <li> 1 Hour of one on one English Learning</li>
                                <li> Choose your own teacher </li>
                                <li> FREE Learning Placement Exams </li>
                                <li> Choose your learning objectives and goals</li>
                            </ul>
                        </div>
                    </div>
                    <div class="pricing_footer">
                        <a href="javascript:" v-on:click="buy(20)" class="btn btn-success btn-block" role="button"> <b>BUY</b> <span> </span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="pricing">
                <div class="title" style="margin:2px">
                    <h2><b>40 Credits</b></h2>
                    <h1>$28</h1>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="pricing_features">
                            <ul class="list-unstyled text-left">
                                <li> 1 Hour of one on one English Learning</li>
                                <li> Choose your own teacher </li>
                                <li> FREE Learning Placement Exams </li>
                                <li> Choose your learning objectives and goals</li>
                            </ul>
                        </div>
                    </div>
                    <div class="pricing_footer">
                        <a href="javascript:void(0);" v-on:click="buy(40)" class="btn btn-success btn-block" role="button"> <b>BUY</b> <span> </span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="pricing">
                <div class="title" style="margin:2px">
                    <h2><b>60 Credits</b></h2>
                    <h1>$40</h1>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="pricing_features">
                            <ul class="list-unstyled text-left">
                                <li> 1 Hour of one on one English Learning</li>
                                <li> Choose your own teacher </li>
                                <li> FREE Learning Placement Exams </li>
                                <li> Choose your learning objectives and goals</li>
                            </ul>
                        </div>
                    </div>
                    <div class="pricing_footer">
                        <a href="javascript:void(0);" v-on:click="buy(60)" class="btn btn-success btn-block" role="button"> <b>BUY</b> <span> </span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="pricing">
                <div class="title" style="margin:2px">
                    <h2><b>100 Credits</b></h2>
                    <h1>$60</h1>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="pricing_features">
                            <ul class="list-unstyled text-left">
                                <li> 1 Hour of one on one English Learning</li>
                                <li> Choose your own teacher </li>
                                <li> FREE Learning Placement Exams </li>
                                <li> Choose your learning objectives and goals</li>
                            </ul>
                        </div>
                    </div>
                    <div class="pricing_footer">
                        <a href="javascript:void(0);" v-on:click="buy(100)" class="btn btn-success btn-block" role="button"> <b>BUY</b> <span> </span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="cForm">
        <input type="hidden" name="sid" id="sid" value="<?php echo Helpers\Text::convertInt( \App\Models\Users\UserEntity::me()->id ); ?>" />
        <input type="hidden" name="credits" id="credits" value="0" />
        <?php echo csrf_field() ?>
    </form>
</div>
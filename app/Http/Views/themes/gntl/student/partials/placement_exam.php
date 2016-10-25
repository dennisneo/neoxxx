<div id="peDiv" class="x_panel tile"  style="min-height:280px">
    <div class="x_title">
        <h3><b>Placement Exam</b></h3>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
        </div>
        <br />
        <div style="text-align: center">
            <a href="<?php echo Url('student/pe/start') ?>" class="btn btn-primary btn-lg"> <b><?php echo trans('general.start_placement_exam') ?></b> </a>
            <a href="javascript:" class="btn btn-default btn-lg" v-on:click="openLearningGoalModal()"> <?php echo trans('general.set_learning_goals') ?>  </a>
        </div>
    </div>

    <div id="learningGoalModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo trans('general.choose_your_learning_goals') ?></h4>
                </div>
                <form id="peForm">
                    <div class="modal-body">
                        <?php echo App\Models\LearningGoals\LearningGoals::checkboxList(); ?>
                    </div>
                    <?php echo csrf_field() ?>
                    <input type="hidden" name="student_id" id="student_id" value="<?php echo \App\Models\Users\UserEntity::me()->id ?>" />
                </form>
                <div class="modal-footer">
                    <button type="button" id="savelg" class="btn btn-primary" v-on:click="saveLearningGoals"><?php echo trans('Save') ?> </button>
                </div>
            </div>
        </div>
    </div>
</div>
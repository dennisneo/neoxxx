<div id="peDiv">

    <div class="x_panel tile" >
        <div class="x_header">

        </div>
        <div class="x_content" style="font-size: 1.2em">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
            </p>

            <div style="text-align: center;margin-top:48px">
                <button v-on:click="openPEModal()" class="btn btn-primary btn-lg"><b> <?php echo trans('general.start_exam') ?> </b></button>
            </div>
            <br />
        </div>
        <input type="hidden" name="student_id" id="student_id" value="<?php echo \App\Models\Users\UserEntity::me()->id ?>" />
    </div>

    <div id="questionaireModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form id="peForm" v-on:submit="doNothing()">
            <?php echo csrf_field() ?>
            <input type="hidden" name="session_id" id="session_id" value="{{ session.eid }}" />
            <input type="hidden" name="question_id" id="question_id" value="{{ question.q_id }}" />

            <div class="modal-content">
                <div class="modal-header">
                    <div class="pull-right">
                        <a href="javascript:" class="btn btn-default" v-on:click="continueLater()"> Continue Later </a>
                    </div>
                    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                    <div>
                        Item {{session.current_item}} of {{session.item_count}}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="v" id="questionDiv">
                        <b> <?php echo trans('general.question') ?> </b>
                        <div id="questions" v-bind:class="question ? '' : 'hide' ">
                            {{ question.question }}
                        </div>
                        <div v-bind:class="question.question ? 'hide' : '' " style="margin-top:24px">
                            <i class="fa fa-refresh fa-spin"></i> Loading Question
                        </div>
                        <hr />
                        <b>Choices:</b>
                        <div v-for="c in choices" v-bind:class="choices.length ? '' : 'hide' ">
                            <input type="radio" name="choice_id" value="{{c.c_id}}" /> {{c.choice}}
                        </div>
                        <div style="margin-top:24px"  v-bind:class="choices.length ? 'hide' : '' ">
                            <i class="fa fa-refresh fa-spin"></i> Loading Choices
                        </div>

                    </div>
                    <div class="v hide" id="resultDiv">
                         <h3><b><?php echo trans('general.exam_results') ?></b> </h3>

                         <table class="table table-striped">
                            <tr>
                                <th>Learning Goal</th>
                                <th>Correct Answers</th>
                                <th>Wrong Answers</th>
                                <th>Items</th>
                                <th>Percentage Score</th>
                            </tr>
                             <tr v-for="r in results">
                                 <td>{{r.goal}}</td>
                                 <td>{{r.correct}}</td>
                                 <td>{{r.wrong}}</td>
                                 <td>{{ ( r.correct + r.wrong ) }}</td>
                                 <td style="text-align: center">{{ convertToPercent( r.rating) }}</td>
                             </tr>
                             <tr>
                                 <th>Total</th>
                                 <th>{{ total_correct }}</th>
                                 <th>{{ total_wrong }}</th>
                                 <th>{{ total_items }}</th>
                                 <th style="text-align: center">{{ total_rating }}</th>
                             </tr>
                         </table>
                    </div>
                    <div class="v">

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btnDiv" id="sButton">
                        <a href="javascript:" type="button" class="btn btn-primary" id="sbtn" v-on:click="submit()"> Submit </a>
                    </div>
                    <div class="btnDiv hide" id="nButton">
                        <div>
                            <a href="javascript:" type="button" class="btn btn-success" v-on:click="bookClass()"> <?php echo trans('general.book_a_class') ?></a>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

</div>

<?php echo \App\Http\Controllers\Student\StudentPartialsController::bookClassPartial( $r ) ?>
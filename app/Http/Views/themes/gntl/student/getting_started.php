<div class="x_panel tile"  style="min-height:120px">
    <div class="x_content" style="font-size: 1.2em">

        <p>Hi <?php echo $student->fullname() ?>, j</p>
        <p>Welcome to Company Name,</p>
        <br />
        <p>
           To get you started we have provided you FREE CREDITS to try one of our teachers available or you may also take
           the placement exam to detemine the right learning modules ....
        </p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
        </p>

    </div>
 </div>

<?php echo \App\Http\Controllers\Student\StudentPartialsController::findTeachersPartial( $r ) ?>

<?php echo \App\Http\Controllers\Student\StudentPartialsController::placementExamPartial( $r ) ?>


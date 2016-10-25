<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\ClassSessions\ClassSessions;
use App\Models\Users\Applicant;
use App\Models\Users\TeacherEntity;
use App\Models\Users\Teachers;
use Helpers\DateTimeHelper;
use Helpers\Text;
use Illuminate\Http\Request;

class AjaxTeachersController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    public function getTeachers( Request $r )
    {
        $teachers  = new Teachers();
        return [
            'success' => true,
            'teachers' => $teachers->vuefyAll( $teachers->getTeachers( $r ) )
        ];
    }

    public function getTeachersForAutocomplete( Request $r )
    {
        $tc         = new Teachers();
        $teachers   = $tc->getTeachers( $r );

        $suggestions    = [];

        foreach( $teachers as $t ){
            $suggestions[] = [ 'data'=> $t->id, 'value' => $t->displayName() ];
        }

        return [
            'suggestions' => $suggestions
        ];
    }

    public function saveTeacher( Request $r )
    {
        $teacher = new TeacherEntity();
        if( ! $teacher->store( $r ) ){
            return [
                'success' => false,
                'message' => $teacher->displayErrors()
            ];
        }

        return [
            'success' => true,
            'teacher' => $teacher
        ];
    }

    public function addSchedule( Request $r )
    {
        $start_time = DateTimeHelper::convertToMinutes( $r->start_time );
        $end_time   = DateTimeHelper::convertToMinutes( $r->end_time );

        $errors = [];
        $sched_arr = [];

        if( $end_time <= $start_time ){
            return [
                'success' =>false,
                'messsage' => 'End time must not be earlier than start time'
            ];
        }

        if( ! isset( $r->dow ) || ! count( $r->dow ) ){
            return [
                'success' =>false,
                'message' => ' You need to select the day of the week ! '
            ];
        }

        $teacher_id = Text::recoverInt( $r->teacher_id );

        $r->request->add([ 'teacher_id'=> $teacher_id, 'from_time' => $start_time , 'to_time' => $end_time  ]);

        foreach( $r->dow as $dow ){

            $schedule = new Teachers\TeacherSchedule;
            if( ! $s = $schedule->store( $r , $dow ) ){
                $errors[] = $schedule->conflict_message;
                continue;
            }

            $sched_arr[] = $s;
        }

        $error_message = implode( '<br />' , $errors );

        if( ! count( $sched_arr ) ){
            return [
                'success' => false,
                'message' => 'No schedule added. All are in conflict with existing schedule',
            ];
        }

        return [
            'success' => true,
            'error_message' => $error_message,
            'schedules' => $sched_arr
        ];
    }

    public function getSchedule( Request $r )
    {
        $schedules = ( new Teachers\TeacherSchedule )->getScheduleByTeacherId( $r->tid )->vuefySchedules();
        $classes = ( new ClassSessions() )->byTeacherId( $r );

        return [
            'success' =>true,
            'schedules' => $schedules,
            'classes' => $classes,
            'tid' => $r->tid
        ];
    }

}
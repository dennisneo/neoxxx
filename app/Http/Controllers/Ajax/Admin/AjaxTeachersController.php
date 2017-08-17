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

        // this use
        foreach( $teachers as $t ){
            $suggestions[] = [ 'data'=> $t->id, 'value' => $t->displayName() ];
        }

        return [
            'suggestions' => $suggestions,
        ];
    }

    public function getTeachersForAutocompleteV2( Request $r )
    {

        $r->merge( ['q' => $r->term ] ) ;

        $tc         = new Teachers();
        $teachers   = $tc->getTeachers( $r );

        $suggestions    = [];

        // this use
        foreach( $teachers as $t ){
            $suggestions[] = [ 'id'=> $t->id, 'value' => $t->displayName() ];

        }

        //$suggestions = [ 1=>'Maria' ,2=> 'Martin' , 3=> 'Allen' ];
        return  $suggestions;
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

        $s_arr = [];
        $s_objects = [];
        foreach( $schedules as $s ){
            $s_arr[ $s->sid ] = [ $s->start_timestamp , $s->end_timestamp ];

            $o_classes = [];
            foreach( $classes as $c ){
                // arrange the classes in order

                if( $c->start_timestamp >= $s->start_timestamp && $c->end_timestamp <= $s->end_timestamp ){
                    // new start time
                    $o_classes[] = $c;
                }
            }

            // sort through
            if( count( $o_classes ) ){

                $latest_start_timestamp = $s->start_timestamp;

                foreach( $o_classes  as $v ){
                    if( $s->start_timestamp == $v->start_timestamp){
                        $latest_start_timestamp = $v->end_timestamp;
                        continue;
                    }
                    // need to break the schedule
                    // create a new s object
                    // second sched
                    $new_sched1 = $s->replicate();
                    $new_sched1->start_timestamp = $latest_start_timestamp;
                    $new_sched1->end_timestamp = $v->start_timestamp;
                    $latest_start_timestamp = $v->end_timestamp;
                    $s_objects[] = $new_sched1;

                }

                if( $latest_start_timestamp < $s->end_timestamp ){
                    $new_sched = $s->replicate();
                    $new_sched->start_timestamp = $latest_start_timestamp;
                    $s_objects[] = $new_sched;
                }
            }else{
                $s_objects[] = $s;
            }

        }



        return [
            'success' =>true,
            'schedules' => $s_objects,
            'classes' => $classes,
            'tid' => $r->tid
        ];
    }

}
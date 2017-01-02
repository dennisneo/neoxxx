<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Ajax\AjaxBaseController;
use App\Models\LearningGoals\LearningGoalMap;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Messaging\Notes;
use App\Models\Users\Applicant;
use App\Models\Users\StudentEntity;
use App\Models\Users\Students;
use App\Models\Users\Teachers;
use App\Models\Users\UserEntity;
use Helpers\Text;
use Illuminate\Http\Request;

class AjaxStudentsController extends AjaxBaseController{

    public function __construct( Request $r )
    {
        parent::__construct( $r );
    }

    /**
     * Called when admin view student personal and learning info
     *
     * @param Request $r
     * @return array
     */
    public function getStudentInfo( Request $r )
    {

         $sid  = $r->sid;
         if( ! $student = StudentEntity::find( $sid ) ){
            return [
                'success' => false,
                'message' => 'Student not found'
            ];
         }

         // also get student learning info
        $learning_info = LearningGoalMap::getLearningGoalsByStudentId( $sid );

         return [
             'success' =>true,
             'student' => $student->vuefyStudent(),
             'learning_info' => $learning_info,
             'sid' => $r->sid
         ];
    }

    public function saveNote( Request $r )
    {

        if( ! trim( $r->note ) ){
            return [
                'success' =>false,
                'message' => 'Note must not be empty'
            ];
        }

        $note   = new Notes;
        $note->note     = $r->note;
        $note->posted_by = UserEntity::me()->id;
        $note->note_to  = $r->student_id;
        $note->posted_at = date( 'Y-m-d H:i:s');
        $note->save();

        return [
            'success' =>true,
            'note' => $note
        ];
    }

    public function getAvailableTeachers( Request $r )
    {
        $teachers = new Teachers;
        $r->request->add(['is_active' => true ]);

        $t_arr = $teachers->vuefyAll( $teachers->getTeachers( $r ) );

        return [
            'success' => true,
            'teachers' =>  $t_arr
        ];

    }

    public function getStudents( Request $r )
    {
        $students  = new Students();
        return [
            'success' => true,
            'students' => $students->vuefyAll( $students->getStudents( $r ) )
        ];
    }


}
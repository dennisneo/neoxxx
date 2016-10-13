<?php


namespace App\Models\Users;

use App\Models\BaseModel;

class TeacherPivot extends BaseModel{

    public $table = 'teachers';
    public $primaryKey = 'teacher_id';

    public $timestamps = false;

}
<?php

namespace App\Models\Users;

use Helpers\Html;
use Illuminate\Http\Request;

class TeacherEntity extends UserEntity{

    public function schedule()
    {

    }

    public function vuefyTeacher()
    {
        $this->vuefyUser();
        return $this;
    }

    public function getAge()
    {
        $from = new \DateTime( $this->birthday );
        $to   = new \DateTime('today');
        return $from->diff($to)->y;
    }
}
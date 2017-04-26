<?php

namespace App\Models\Users;

use App\Models\ClassSessions\ClassSessions;
use Illuminate\Http\Request;

class Admins extends UserEntity{

    public function getAll()
    {
        return static::where( 'user_type' , 'admin' )
            ->where( 'is_deleted' , 0 )
            ->get();
    }

}
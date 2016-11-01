<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Financials;

use App\Models\Settings\Settings;
use App\Models\Users\Students\StudentCredits;
use App\Models\Users\UserEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

// Deprecated
// use StudentCredits instead

class Credits extends Model{

    protected $table        = 'user_credits';
    protected $primaryKey   = 'map_id';
    public $timestamps = false;

    public $fillable    = [];
    private $errors     = [];


    public static function getCreditsByStudentId( $student_id , $return_model = false )
    {
        return StudentCredits::getCreditsByStudentId( $student_id , $return_model );
    }

    public static function getCreditsByDuration( $duration )
    {
        return StudentCredits::getCreditsByDuration( $duration );
    }

}
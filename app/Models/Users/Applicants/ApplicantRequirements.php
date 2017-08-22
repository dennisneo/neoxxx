<?php

namespace App\Models\Users\Applicants;

use App\Models\BaseModel;
use App\Models\Financials\Payments;
use App\Models\Settings\Settings;
use Carbon\Carbon;
use Helpers\Text;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class ApplicantRequirements extends BaseModel{

    protected $table = 'applicant_requirements';
    protected  $primaryKey = 'map_id';

    public $timestamps = false;

    protected $fillable = [ 'map_id' , 'applicant_id' ];

    /**
     * @param $applicant_id
     * @return static
     */
    public static function record( $applicant_id )
    {
        $req = static::where( 'applicant_id' , $applicant_id )
            ->first();

        if( ! $req ){
            $req = new static;
        }

        return $req;
    }

    public function store( Request $r )
    {
        $this->fill( $r->all() );
        $this->valid_credentials = $r->valid_credentials ? 1 : 0;
        $this->fast_internet = $r->fast_internet ? 1 : 0;
        $this->comfortable_home_office = $r->comfortable_home_office ? 1 : 0;
        $this->audio_recording = $r->audio_recording ? 1 : 0;
        $this->appropriate_schedule = $r->appropriate_schedule ? 1 : 0 ;
        $this->cv = $r->cv ?  $r->cv  : null ;
        $this->save();

        return $this;
    }
}
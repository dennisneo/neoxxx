<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Messaging;

use App\Models\Settings\Settings;
use App\Models\Users\UserEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class NotificationMap extends Model{

    protected $table        = 'notification_map';
    protected $primaryKey   = 'map_id';
    public $timestamps = false;

    public $fillable    = [];
    private $errors     = [];

    public function store( $data = [] )
    {
        $data = json_decode( json_encode( $data ) );

        $this->notification_id  = $data->notification_id;
        $this->sent_to          = $data->sent_to;
        $this->entity           = '';
        $this->sent_at = date( 'Y-m-d H:i:s' );

        $this->save();

        return $this;
    }

    public function getErrors()
    {
        $html = '<ul>';
        foreach( $this->errors as $e ){
            $html .= '<li>'.$e.'</li>';
        }
        $html .= '</ul>';

        return $html;
    }


}
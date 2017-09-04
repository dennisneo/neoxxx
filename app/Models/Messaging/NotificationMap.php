<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Messaging;

use App\Models\BaseModel;
use App\Models\Settings\Settings;
use App\Models\Users\UserEntity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class NotificationMap extends BaseModel{

    protected $table        = 'notification_map';
    protected $primaryKey   = 'map_id';
    public $timestamps = false;

    public $fillable    = [ 'url' ];

    public function getCollection( Request $r )
    {
        $this->setLpo( $r );
        $this->fields = [ 'a.*' , 'n.notification' ];

        $this->query = static::from( $this->table.' as a' )
            ->join( 'notifications as n' , 'n.notification_id' , '=' ,'a.notification_id')
            ->where( 'sent_to' , $r->sent_to );
        // apply filters here

        if( $r->return_total ){
           $this->total = $this->query->count( );
        }

        $this->assignLpo();

        if( $r->return_builder ){
            return $this->query;
        }

        //$this->query->get( $this->fields );
        return $this->vuefyThisCollection();
    }

    public function store( $data = [] )
    {
        $data = (object) $data ;

        $this->notification_id  = $data->notification_id;
        $this->sent_to          = $data->sent_to;
        $this->entity           = '';
        $this->sent_at = date( 'Y-m-d H:i:s' );

        $url = isset( $data->url ) ? $data->url : '' ;

        $this->save();

        return $this;
    }

    public function getSentAtAttribute( $value )
    {
        return Carbon::createFromTimestamp( strtotime( $value ))->diffForHumans();
    }

    public function vuefy()
    {
        $this->notification_text =  $this->notificationText( $this->notification );
        return $this;
    }

    private function notificationText( $value )
    {
        if( substr( $value , 0 , 8   ) == 'general.' || substr( $value , 0 , 14   ) == 'notifications.' ){
            return trans( $value );
        }

        return $value;
    }
}
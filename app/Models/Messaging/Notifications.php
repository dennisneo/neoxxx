<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Messaging;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Notifications extends Model{

    protected $table        = 'notifications';
    protected $primaryKey   = 'notification_id';
    public $timestamps = false;

    public $fillable    = [ 'notification' ];
    private $errors     = [];

    public function send( $nkey , $data = [] )
    {
        if( !$nkey ){
            $this->errors[] = trans('general.invalid_notification_key');
            return false;
        }

        // check if key already set
        $n = static::where( 'nkey' , $nkey )->first();

        if( ! $n ){
            $data['nkey'] = $nkey;
            $n = $this->store( $data );
        }

        $data['notification_id'] = $n->notification_id;

        // add to notification map
        $n = ( new NotificationMap )->store( $data );


    }

    public function store( $data = [] )
    {
        $no  = json_decode( json_encode($data ) );

        $n   = new static;
        $n->notification = $no->notification;
        $n->nkey    = $no->nkey;
        $n->params = serialize( [] );

        $n->save();

        return $n;
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
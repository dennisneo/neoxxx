<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 8/1/2016
 * Time: 8:29 PM
 */

namespace App\Models\Utilities;

use App\Models\Users\UserEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class Modifications extends Model
{
    protected $table = 'modifications';
    protected $primaryKey = 'mod_id';
    public $timestamps = false;

    public $fillable = [ 'details' , 'old_value' ,
        'new_value', 'entity' , 'entity_id' , 'attribute'];
    private $errors = [];
    private $total = 0;


    public static function add( array $options )
    {
        $mod = new static;

        // convert array  to objects
        /// $mod = json_decode(json_encode( $options ), FALSE);

        $mod->fill( $options );
        $mod->modified_by  = UserEntity::me()->id;
        $mod->modified_at  = date( 'Y-m-d H:i:s');

        $mod->save();

        return $mod;
    }

    public function getTotal()
    {
     return $this->total;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

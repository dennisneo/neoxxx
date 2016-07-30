<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/28/2016
 * Time: 10:31 AM
 */

namespace App\Models\Users;

use Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserEntity extends Model{

    protected $table      = 'users';
    protected $primaryKey = 'id';

    public $fillable = [ 'id', 'email' , 'user_type' , 'first_name' , 'last_name',
     'landline' , 'mobile' , 'country', 'city', 'gender' ];

    private  $errors = [];

    private static $instances = [];

    public static function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|unique:users'
        ];
    }

    public function store( Request $r )
    {
        // save a new applicant
        // check if email is already found
        $validator = Validator::make( $r->all(),  User::rules() );

        if( $validator->fails() ){
            $this->errors = $validator->errors()->all();
            return false;
        }

        $user =  $r->id ? static::find( $r->id ) : new static();

        if( ! $user ){
            $this->errors = ['Invalid user'];
            return false;
        }

        $user->fill( $r->all() );
        $params = unserialize( $user->params );

        if( ! $user->id ){

            $params['pwd']  = md5( str_random( 12 ) );
            $password       = $this->getPassword( $params['pwd'] );

            $user->username     = $r->email;
            $user->password     = \Hash::make( $password );

        }

        $user->created_at   = date( 'Y-m-d H:i:s');
        $user->params = serialize( $params );
        $user->save();

        return $user;
    }

    /**
     * so we can save password to db we used a simple md5 string to get pwd
     * @param $md5 *
     * @return string
     */
    public function getPassword( $md5 )
    {
        $str = collect( str_split( $md5 ) );
        $pwd_str = $str->every( 6 )->toArray();

        return implode( '' , $pwd_str );
    }

    /**
     * errors generated by Validation will be processed through this method
     * @return null|string
     */
    public function displayErrors()
    {
        if( ! count( $this->errors )){
            return null;
        }

        $html = '<ul>';

        foreach( $this->errors as $e ){
            $html .= '<li>'.$e.'</li>';
        }
        $html .= '</ul>';

        return $html;
    }

    /**
     * Create an instance of the current user
     * @param $current
     * @return mixed
     */
    public static function setupMe( $user )
    {
        static::$instances[ 'me' ] = $user;
        return $user;
    }

    public static function me()
    {
        return isset( static::$instances[ 'me' ] ) ? static::$instances[ 'me' ] : null;

    }

}
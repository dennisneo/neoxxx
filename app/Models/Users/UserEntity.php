<?php

namespace App\Models\Users;

use App\Http\Models\Locations\Countries;
use App\Models\BaseModel;
use Helpers\Html;
use Helpers\Text;
use Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserEntity extends BaseModel{

    protected $table      = 'users';
    protected $primaryKey = 'id';

    public $fillable = [ 'id', 'email' , 'user_type' , 'first_name' , 'last_name', 'middle_name',
     'birthday', 'landline' , 'mobile' , 'country', 'city', 'gender' , 'skype' , 'qq' , 'address' , 'timezone' ];

    protected  $errors = [];

    private static $instances = [];
    protected $hidden =['password' , 'confirmation_code' , 'remember_token' , 'params' ];
    protected $appends = ['full_name'];

    public static function rules( $exists = false )
    {

        if( $exists ){
            return [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required'
            ];
        }

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|unique:users'
        ];

    }

    public function store( Request $r )
    {
        if( $r->id ){
            $this->exists = true;
        }

        // save a new applicant
        // save a new student
        // check if email is already found
        $validator = Validator::make( $r->all(),  static::rules( $this->exists ) );

        if( $validator->fails() ){
            $this->errors = $validator->errors()->all();
            return false;
        }

        $this->fill( $r->all() );
        $params = unserialize( $this->params );

        if(  $this->id ) {
            $this->exists = true;
        }else{

            $params['pwd']  = md5( str_random( 12 ) );
            $password       = $this->getPassword( $params['pwd'] );

            $this->username     = $r->email;
            $this->password     = \Hash::make( $password );
            $this->confirmation_code = Text::random( null, 16 );
            $this->status       = 'new';
            $this->created_at   = date( 'Y-m-d H:i:s');

            $this->timezone =  $r->timezone ? $r->timezone : 'Asia/Singapore';

        }

        $this->params = serialize( $params );
        $this->save();

        return $this;
    }

    public function uploadProfilePhoto( Request $r )
    {
        if( ! $this->id ){
            // can save photo only when user is set
            $this->errors[] = 'Invalid user id';
            return false;
        }

        $valid_files = [ 'png', 'jpg', 'jpeg', 'JPG', 'JPEG' ];
        $ext = $r->file( 'photo' )->getClientOriginalExtension();

        if( ! in_array( $ext , $valid_files  ) ){
            $this->errors[] = 'Invalid file type. Only png and jpg files are allowed';
            return false;
        }

        $orig_filename = $r->file( 'photo' )->getClientOriginalName();
        $new_filename = 'profile_'.str_random( 12 ).'.'.$ext;

        $destination = '/public/images/users/'.Text::convertInt( $this->id ).'/';
        $url = url( $destination.$new_filename );

        $destination  = public_path().''.$destination;

        if( ! is_dir( $destination )){
            mkdir( $destination , 755 , true );
        }

        $r->file('photo')->move( $destination , $new_filename );
        $file_path = $destination.$new_filename;

        $img = \Image::make( $file_path )->fit( 200, 200)->save();

        $this->profile_photo_url = $url;
        $this->save();

        return $this;

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

    public function getFullNameAttribute()
    {
        return $this->displayName();
    }

    public function displayName( $style = 'default')
    {
        $name = $this->last_name.', '.$this->first_name.' ';
        switch( $style ){
           case  'simple':
               $name = $this->first_name.' '.$this->last_name;
           break;
           case  'short':
                $name = $this->first_name.' '.substr( $this->last_name ,0 , 1 );
           break;
           default:
               $name = $this->last_name.', '.$this->first_name.' ';
           break;
        }

        return $name;
    }

    public function profilePhotoUrl()
    {
        $subdir = env( 'SUBDIR' ) ? '/'.env( 'SUBDIR' ):'';
        return $this->profile_photo_url ? $this->profile_photo_url : $subdir.'/public/images/blank_face.png';
    }

    public function vuefyUser()
    {
        $this->profile_photo_url = $this->profile_photo_url ? $this->profile_photo_url : url( 'public/images/blank_face.png' );
        $this->short_name = $this->displayName( 'short' );
        $this->full_name = $this->displayName( 'default' );
        $this->cid =  Text::convertInt( $this->id );
        $this->location = $this->city.' '.$this->country;
        return $this;
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


    public function fullname(){
        return ucfirst( strtolower($this->first_name.' '.$this->last_name) );
    }
    /**
     * @return UserEntity
     */
    public static function me()
    {
        return isset( static::$instances[ 'me' ] ) ? static::$instances[ 'me' ] : null;

    }

    public function isAdmin()
    {
        return $this->user_type == 'admin' ? true : false;
    }

    public  function resendConfirmationEmail()
    {
        view()->addLocation( base_path().'/app/Http/Views/emails' );

        // check first if email is valid
        $user = $this;

        \Mail::send('confirm_account', ['user' => $user ],
            function ($m) use ( $user ) {
                $m->from( env( 'APP_EMAIL_SENDER' ), trans('general.confirm_account') );
                $m->to( $user->email, $user->displayName() )
                    ->subject( trans( 'general.confirmation_subject' ) );
            });
    }


}
<?php

namespace App\Models\Locations;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Countries extends BaseModel{

    protected  $table = 'countries';
    protected $primaryKey = 'country_id';

    public function getCollection( Request $r )
    {
        $this->setLpo( $r );
        $this->fields = [ 'a.*' ];

        $this->query = static::from( $this->table.' as a' );
        // apply filters here

        if( $r->return_total ){
           $this->total = $this->query->count( );
        }

        $this->assignLpo();

        if( $r->return_builder ){
            return $this->query;
        }

        return $this->query->get( $this->fields );
    }

    public static function selectList( $options = [] )
    {
        $countries = static::orderby( 'country' )
            ->get();

        $c_arr[0] ='Select Country';
        foreach( $countries as $c ){
            $c_arr[ $c->code ] = $c->country;
        }

        $default = isset( $options['default'] ) ? $options['default'] : 0;

        if( isset( $options['model'] ) &&  $options['model'] ) {
            return \Form::select( 'country', $c_arr  , $default , [ 'class' => 'form-control' , 'v-model' => $options['model'] ] );
        }
        return \Form::select( 'country', $c_arr  , $default , [ 'class' => 'form-control' ] );
    }

}
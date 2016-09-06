<?php

namespace App\Http\Models\Locations;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Countries extends Model{

    protected  $table = 'countries';
    protected $primaryKey = 'country_id';

    public static function selectList( $options = [] )
    {
        $countries = static::orderby( 'country')
            ->get();

        $c_arr[0] ='Select Country';
        foreach( $countries as $c ){
            $c_arr[ $c->code ] = $c->country;
        }

        $default = isset( $options['default'] ) ? $options['default'] : 0;

        return \Form::select( 'country', $c_arr  , $default , [ 'class' => 'form-control' ] );
    }

    public static function vueFy( Collection $articles )
    {
        $a_arr =  [];
        foreach( $articles as $a ){
            $a_arr[] =  $a->vueFormat();
        }

        return $a_arr;
    }
}
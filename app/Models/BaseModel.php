<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseModel extends \Eloquent
{
    protected $total     = 0;
    protected $pages     = 1;
    protected $page      = 1; // current_page
    protected $limit     = 20;
    protected $errors    = [];
    protected $collection    = [];
    protected $sql;

    public $error_code;

    public function getTotal()
    {
        return $this->total;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function getPageCount( $return_array = false )
    {
        if( ! $this->total ){
            return 0;
        }
        $count =  ceil( $this->total / $this->limit   );

        if( $return_array ){
            $_arr = [];
            for( $i = 1 ; $i <= $count ; $i++ ){
                $_arr[] = $i;
            }
            return $_arr;
        }

        return $count;
    }

    public function getCurrentPage()
    {
        return $this->page;
    }


    public function getErrors()
    {
        return $this->errors;
    }

    public function displayErrors()
    {
        if( ! count( $this->errors )){
            return '';
        }

        $html = '<ul>';
        foreach( $this->errors as $e ){
            $html .= '<li>'.$e.'</li>';
        }
        $html .= '</ul>';

        return $html;
    }

    public function vuefyThisCollection()
    {
        $c_arr = [];
        foreach( $this->collection as $c ){
            $c_arr[] = $c->vuefy();
        }

        return $c_arr;
    }

    public function vuefyCollection( Collection $collection )
    {
        $c_arr = [];
        foreach( $collection as $c ){
            $c_arr[] = $c->vuefy();
        }

        return $c_arr;
    }

    public function vuefy()
    {
        return $this;
    }

    public function getSql()
    {
        return $this->sql;
    }

}
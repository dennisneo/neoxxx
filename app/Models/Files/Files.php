<?php

namespace App\Models\Files;

use App\Models\BaseModel;
use Illuminate\Http\Request;

class Files extends BaseModel{

    protected $table        = 'files';
    protected $primaryKey   = 'file_id';

    public $fillable    = [ ];

    public function store( Request $r )
    {
        $validator = \Validator::make( $r->all() , [
            // validation rules here
        ] );

        if( $validator->fails() ){
            $this->errors = $validator->errors()->all();
            return false;
        }

        $this->fill( $r->all() );
        $pk = $this->primaryKey;

        if( $r->$pk  ){
            $this->exists = true;
        }else{

        }

        $this->save();

        return $this;
    }
}
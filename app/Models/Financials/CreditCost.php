<?php

namespace App\Models\Financials;

use App\Models\BaseModel;
use App\Models\Users\Students\StudentCredits;
use Illuminate\Http\Request;
use Validator;

class CreditCost extends BaseModel{

    protected $table        = 'credit_cost';
    protected $primaryKey   = 'cost_id';
    public $timestamps = false;

    public $fillable    = [];


}
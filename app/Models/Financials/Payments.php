<?php

namespace App\Models\Financials;

use App\Models\BaseModel;
use App\Models\Users\Students\StudentCredits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class Payments extends BaseModel{

    protected $table        = 'payments';
    protected $primaryKey   = 'payment_id';
    public $timestamps = false;

    public $fillable    = [];

    public function getAll( Request $r )
    {
        $limit = $r->limit ? $r->limit : 20;
        $page = $r->page ? $r->page : 1;
        $offset = ($page-1) * $limit;
        $order_by = $r->order_by ? $r->order_by : '';
        $order_direction = $r->order_direction ? $r->order_direction : 'ASC';

        $p = static::from( 'payments as p')
        ->join( 'users as u' , 'p.user_id' , '=' , 'u.id' );

        $this->collection =   $p->get( ['p.*' , 'u.first_name' , 'u.last_name' ]);

        return $this;
    }

    public function vuefy()
    {
        return $this;
    }

    public function execute( Request $r )
    {
        // transact wepay here
        $transaction_code = 'we_pay_code';

        $this->user_id = $r->user_id;
        $this->amount =  $r->amount;
        $this->credits =  $r->credits;
        $this->cost_id =  $r->cost_id;
        $this->paid_at = date('Y-m-d H:i:s');
        $this->transaction_code = $transaction_code;

        $params['package'] = $r->cost_id;
        $this->params = serialize( $params );

        $this->save();

        return true;
    }

}
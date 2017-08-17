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

    public $fillable    = [ 'cost_id', 'credits' ];

    private $sum;

    public function getCollection( Request $r )
    {
        $limit = $r->limit ? $r->limit : 20;
        $page = $r->page ? $r->page : 1;
        $offset = ($page-1) * $limit;
        $order_by = $r->order_by ? $r->order_by : '';
        $order_direction = $r->order_direction ? $r->order_direction : 'ASC';

        $query = static::from( 'payments as p')
        ->leftjoin( 'users as u' , 'p.user_id' , '=' , 'u.id' );

        if( $r->from && $r->to ){
            $query->where( 'paid_at', '>=', $r->from );
            $query->where( 'paid_at', '<=', $r->to );
        }elseif( $r->from ){
            $query->where( 'paid_at', '>=', $r->from );
        }elseif( $r->to ){
            $query->where( 'paid_at', '<=', $r->to );
        }

        $this->total    = $query->count();
        $this->sum      = $query->sum( 'amount' );

        $this->collection =   $query->get(
            ['p.*' , 'u.first_name' , 'u.last_name' ]);

        return $this->vuefyThisCollection();
    }

    public function vuefy()
    {
        $this->student_name = $this->last_name.', '.$this->first_name;
        return $this;
    }

    public function getPaidAtAttribute( $value )
    {
        return date( 'M d, Y h:i a', strtotime( $value ));
    }

    /**
     * Alipay payment
     *
     * @param Request $r
     * @return $this|bool
     */
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

        // payments data are never editable

        $this->user_id      =   $r->user_id;
        $this->amount       =   $r->total_fee;
        $this->paid_at = date('Y-m-d H:i:s');

        $this->transaction_code = $r->trade_no;
        $package = CreditCost::find( $r->cost_id );

        if( $package ){
            $params['package'] = $package->all();
        }

        $this->params = json_encode( $params );
        $this->save();


        return $this;
    }

    public function execute( Request $r  )
    {
        return $this->store( $r );
    }

    public function getSum()
    {
        return $this->sum;
    }

}
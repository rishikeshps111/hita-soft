<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DemoOrders extends Model
{
    protected $primaryKey = 'id';
    public $table = 'demo_orders';
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function Users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function Reference()
    {
        return $this->belongsTo('App\Orders','ref_order_id','id');
    }

    public function GRV()
    {
        return $this->belongsTo('App\GrvOrders','grv_id','id');
    }
    
    public function orderDetails()
    {
        return $this->hasMany('App\DemoOrderDetails', 'order_id', 'id');
    }
    
    public function payment()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_mode');
    }
    
      public function order_trans()
    {
        return $this->hasOne('App\DemoOrdersTransactions', 'order_id', 'id');
    }


}

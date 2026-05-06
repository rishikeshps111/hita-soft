<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Orders extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    public $table = 'orders';
    protected $hidden = [
        'created_at', 'updated_at'
    ];
     protected $dates = ['deleted_at'];

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
        return $this->hasMany('App\OrderDetails', 'order_id', 'id');
    }
    
    public function payment()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_mode');
    }
    
      public function order_trans()
    {
        return $this->hasOne('App\OrdersTransactions', 'order_id', 'id');
    }


}

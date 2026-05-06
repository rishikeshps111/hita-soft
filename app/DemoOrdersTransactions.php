<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DemoOrdersTransactions extends Model
{
    protected $primaryKey = 'id';
    public $table = 'demo_orders_transactions';
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    
      public function order()
    {
        return $this->belongsTo('App\DemoOrders', 'order_id', 'id');
    }
    
}

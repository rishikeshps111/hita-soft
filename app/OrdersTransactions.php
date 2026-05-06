<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdersTransactions extends Model
{
    
     use SoftDeletes;
    protected $primaryKey = 'id';
    public $table = 'orders_transactions';
    protected $hidden = [
        'created_at', 'updated_at'
    ];
     protected $dates = ['deleted_at'];

    
      public function order()
    {
        return $this->belongsTo('App\Orders', 'order_id', 'id');
    }
    
}

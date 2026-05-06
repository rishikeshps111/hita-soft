<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DemoOrderDetails extends Model
{
    protected $primaryKey = 'id';
    public $table = 'demo_order_details';
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function Orders()
    {
        return $this->belongsTo('App\DemoOrders','order_id','id');
    }

    public function Products()
    {
        return $this->belongsTo('App\Products','product_id','id');
    }

    public function AttName()
    {
        return $this->belongsTo('App\AttributesFields','att_name','id');
    }

    public function AttValue()
    {
        return $this->belongsTo('App\AttributesSettings','att_value','id');
    }
}

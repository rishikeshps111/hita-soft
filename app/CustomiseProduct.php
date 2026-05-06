<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomiseProduct extends Model
{
    protected $primaryKey = 'id';
    public $table = 'customise_products';
     protected $fillable = [
        'name','user_id','order_code','product_name', 'email', 'company_name', 'company_website', 
        'packing_item', 'box_quantity', 'box_dimension', 
        'box_type', 'uploaded_image','payment_mode','payment_status','order_status', 'phone_number', 'message'
    ];
    protected $hidden = [
        'updated_at'
    ];

}

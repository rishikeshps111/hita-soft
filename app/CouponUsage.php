<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    protected $primaryKey = 'id';
    public $table = 'coupon_usages';
    protected $fillable = [
        'user_id',
        'coupon_code',
        'order_id',
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
    
    public function user()
{
    return $this->belongsTo(User::class);
}

public function order()
{
    return $this->belongsTo(Orders::class, 'order_id');
}


}

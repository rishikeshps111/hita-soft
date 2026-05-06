<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $primaryKey = 'id';
    public $table = 'coupons';
    protected $hidden = [
        'created_at','updated_at'
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user'); // or a CouponUsage model
    }
    
    public function usages()
{
    return $this->hasMany(CouponUsage::class, 'coupon_code', 'code');
}

    
}

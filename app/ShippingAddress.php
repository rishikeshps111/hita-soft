<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $primaryKey = 'id';
    public $table = 'shipping_addresses';
    protected $hidden = [
        'created_at','updated_at'
    ];

    public function Users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function Countrys()
    {
        return $this->belongsTo('App\CountriesManagement','country','id');
    }

    public function States()
    {
        return $this->belongsTo('App\StateManagements','state','id');
    }

    public function Citys()
    {
        return $this->belongsTo('App\CityManagement','city','id');
    }
}

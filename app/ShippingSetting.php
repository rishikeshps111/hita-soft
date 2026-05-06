<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingSetting extends Model
{
    protected $primaryKey = 'id';
    public $table = 'shipping_settings';
    protected $hidden = [
        'created_at','updated_at'
    ];
}

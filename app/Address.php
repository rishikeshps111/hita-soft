<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $primaryKey = 'id';
    public $table = 'addresses';
     protected $fillable = [
        'user_id',
        'address_type',
        'title',
        'address2',
        'address3',
        'locality',
        'pincode',
        'is_default',
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $primaryKey = 'id';
    public $table = 'payment_methods';
    protected $fillable = ['name', 'is_enabled'];
    protected $hidden = [
        'created_at','updated_at'
    ];
}

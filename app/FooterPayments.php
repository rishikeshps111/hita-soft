<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterPayments extends Model
{
    protected $primaryKey = 'id';
    public $table = 'footer_payments';
    protected $hidden = [
        'updated_at'
    ];
}

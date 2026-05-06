<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FAQS extends Model
{
    protected $primaryKey = 'id';
    public $table = 'faqs';
    protected $hidden = [
        'created_at','updated_at'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributesFields extends Model
{
    protected $primaryKey = 'id';
    public $table = 'attributes_fields';
    protected $hidden = [
        'updated_at','created_at'
    ];
}

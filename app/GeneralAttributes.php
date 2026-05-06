<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralAttributes extends Model
{
    protected $primaryKey = 'id';
    public $table = 'general_attributes';
    protected $hidden = [
        'created_at','updated_at'
    ];
}

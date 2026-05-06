<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityManagement extends Model
{
    protected $primaryKey = 'id';
    public $table = 'city_managements';
    protected $hidden = [
        'created_at','updated_at'
    ];
}

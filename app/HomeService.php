<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeService extends Model
{
    protected $primaryKey = 'id';
    public $table = 'home_services';

    protected $fillable = [
        'title',
        'description',
        'image',
        'priority',
        'is_block',
    ];
}

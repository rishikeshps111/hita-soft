<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $primaryKey = 'id';
    public $table = 'career';
    protected $hidden = [
        'created_at','updated_at'
    ];
}

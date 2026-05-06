<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutAwards extends Model
{
    protected $primaryKey = 'id';
    public $table = 'about_awards';
    protected $hidden = [
        'created_at','updated_at'
    ];
}

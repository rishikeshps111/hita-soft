<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteLock extends Model
{
    protected $primaryKey = 'id';
    public $table = 'website_lock';
    protected $hidden = [
        'created_at','updated_at'
    ];
}

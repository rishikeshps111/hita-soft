<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeaderMenus extends Model
{
    protected $primaryKey = 'id';
    public $table = 'header_menus';
    protected $hidden = [
        'updated_at'
    ];
}

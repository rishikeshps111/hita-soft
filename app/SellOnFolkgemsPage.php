<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellOnFolkgemsPage extends Model
{
    protected $primaryKey = 'id';
    public $table = 'sell_on_folkgems_page';
    protected $hidden = [
        'created_at','updated_at'
    ];
}

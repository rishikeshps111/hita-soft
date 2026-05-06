<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterLinks extends Model
{
    protected $primaryKey = 'id';
    public $table = 'footer_all_links';
    protected $hidden = [
        'updated_at'
    ];
}

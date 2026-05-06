<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $primaryKey = 'id';
    public $table = 'footer_setting';
    protected $hidden = [
        'updated_at'
    ];
}

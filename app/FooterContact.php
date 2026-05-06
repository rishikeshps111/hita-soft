<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterContact extends Model
{
    protected $primaryKey = 'id';
    public $table = 'footer_contact';
    protected $hidden = [
        'updated_at'
    ];
}

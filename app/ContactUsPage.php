<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUsPage extends Model
{
    protected $primaryKey = 'id';
    public $table = 'contact_us_page';
    protected $hidden = [
        'created_at','updated_at'
    ];
}

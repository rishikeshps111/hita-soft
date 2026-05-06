<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FAQPage extends Model
{
    protected $primaryKey = 'id';
    public $table = 'faq_page';
    protected $hidden = [
        'created_at','updated_at'
    ];
}

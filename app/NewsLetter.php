<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    protected $primaryKey = 'id';
    public $table = 'news_letters';
     protected $fillable = [
        'email',
        'is_block',
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
}

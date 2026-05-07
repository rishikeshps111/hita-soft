<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $primaryKey = 'id';
    public $table = 'contacts';
    protected $fillable = [
        'contact_name',
        'contact_email',
        'contact_phone',
        'subject',
        'message',
        'is_block',
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
}

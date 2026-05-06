<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OurArtist extends Model
{
    protected $primaryKey = 'id';
    public $table = 'our_artist';
    protected $hidden = [
        'updated_at'
    ];
}

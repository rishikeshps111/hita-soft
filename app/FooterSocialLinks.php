<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterSocialLinks extends Model
{
    protected $primaryKey = 'id';
    public $table = 'footer_social_links';
    protected $hidden = [
        'updated_at'
    ];
}

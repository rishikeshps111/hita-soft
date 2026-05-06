<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestimonialSetting extends Model
{
    protected $primaryKey = 'id';
    public $table = 'testimonial_setting';
    protected $hidden = [
        'updated_at'
    ];
}

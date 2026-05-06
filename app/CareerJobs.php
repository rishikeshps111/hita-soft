<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CareerJobs extends Model
{
    protected $primaryKey = 'id';
    public $table = 'career_jobs';
    protected $hidden = [
        'created_at','updated_at'
    ];
}

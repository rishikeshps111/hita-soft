<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CareerForm extends Model
{
    protected $primaryKey = 'id';
    public $table = 'career_form';
    protected $hidden = [
        'created_at','updated_at'
    ];

    public function Jobs()
    {
        return $this->belongsTo('App\CareerJobs','job','id');
    }
}

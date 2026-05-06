<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategoryManagementSettings extends Model
{
    protected $primaryKey = 'sub_cat_id';
    public $table = 'sub_category_management_settings';
    protected $hidden = [
        'created_at','updated_at'
    ];
    
     public function products() {
        return $this->hasMany(Products::class,'sub_cat_name','sub_cat_id');
    }

}

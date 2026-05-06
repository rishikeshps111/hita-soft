<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryManagementSettings extends Model
{
    protected $primaryKey = 'id';
    public $table = 'category_management_settings';
    protected $hidden = [
        'created_at','updated_at'
    ];
    
    public function products() {
        return $this->hasMany(Products::class,'main_cat_name','id');
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategoryManagementSettings::class, 'main_cat_name', 'id');
    }

    
}

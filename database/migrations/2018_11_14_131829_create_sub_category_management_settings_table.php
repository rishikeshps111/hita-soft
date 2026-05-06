<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoryManagementSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_category_management_settings', function (Blueprint $table) {
            $table->increments('sub_cat_id');
            $table->integer('main_cat_name')->unsigned()->nullable();
            $table->string('sub_cat_name',255)->nullable();
            $table->string('sub_cat_image',255)->nullable();
            $table->integer('is_block')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_category_management_settings');
    }
}

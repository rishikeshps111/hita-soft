<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryManagementSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_management_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('main_cat_name',255)->nullable();
            $table->string('main_cat_image',255)->nullable();
            $table->string('main_cat_icon',255)->nullable();
            $table->integer('is_home')->default(0);
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
        Schema::dropIfExists('category_management_settings');
    }
}

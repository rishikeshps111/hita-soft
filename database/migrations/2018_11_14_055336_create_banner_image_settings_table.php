<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerImageSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_image_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_title',255)->nullable();
            $table->string('banner_image',255)->nullable();
            $table->string('redirect_url',255)->nullable();
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
        Schema::dropIfExists('banner_image_settings');
    }
}

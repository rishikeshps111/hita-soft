<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoimageSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noimage_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_image',255)->nullable();
            $table->string('profile_no_img',255)->nullable();
            $table->string('product_no_image',255)->nullable();
            $table->string('deal_no_image',255)->nullable();
            $table->string('stores_no_image',255)->nullable();
            $table->string('blog_banner_no_image',255)->nullable();
            $table->string('banner_no_image',255)->nullable();
            $table->string('category_banner_no_image',255)->nullable();
            $table->string('ads_no_image',255)->nullable();
            $table->string('category_no_image',255)->nullable();
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
        Schema::dropIfExists('noimage_settings');
    }
}

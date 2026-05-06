<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialMediaSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_media_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facebook_app_id',255)->nullable();
            $table->string('facebook_secrect_key',255)->nullable();
            $table->string('facebook_page_url',255)->nullable();
            $table->string('facebook_like_url',255)->nullable();
            $table->string('twitter_page_url',255)->nullable();
            $table->string('twitter_app_id',255)->nullable();
            $table->string('twitter_secrect_key',255)->nullable();
            $table->string('linkedin_page_url',255)->nullable();
            $table->string('youtube_url',255)->nullable();
            $table->string('google_plus_url',255)->nullable();
            $table->string('instagram_url',255)->nullable();
            $table->string('pinterest_url',255)->nullable();
            $table->string('gmap_app_key',255)->nullable();
            $table->text('analytics_code')->nullable();
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
        Schema::dropIfExists('social_media_settings');
    }
}

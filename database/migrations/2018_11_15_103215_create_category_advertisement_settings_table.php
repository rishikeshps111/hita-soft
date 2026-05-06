<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryAdvertisementSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_advertisement_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ad_title',255)->nullable();
            $table->string('ad_website',255)->nullable();
            $table->timestamp('ad_start_date')->nullable()->useCurrent = true;
            $table->timestamp('ad_end_date')->nullable();
            $table->string('ad_image',255)->nullable();
            $table->string('cust_name',255)->nullable();
            $table->string('cust_no',255)->nullable();
            $table->double('amount')->nullable();
            $table->integer('payment_status')->nullable();
            $table->string('page',255)->nullable();
            $table->string('position',255)->nullable();
            $table->integer('main_cat_name')->unsigned()->nullable();
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
        Schema::dropIfExists('category_advertisement_settings');
    }
}

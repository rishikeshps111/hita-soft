<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant')->unsigned()->nullable();
            $table->string('store_name',255)->nullable();
            $table->string('store_phone',255)->nullable();
            $table->string('store_address1',255)->nullable();
            $table->string('store_address2',255)->nullable();
            $table->integer('store_country')->unsigned()->nullable();
            $table->integer('store_city')->unsigned()->nullable();
            $table->integer('store_zipcode')->nullable();
            $table->string('meta_keyword',255)->nullable();
            $table->string('meta_description',255)->nullable();
            $table->string('website',255)->nullable();
            $table->string('slogan',255)->nullable();
            $table->string('stores_image',255)->nullable();
            $table->integer('is_block')->nullable();
            $table->integer('login_type')->nullable();
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
        Schema::dropIfExists('stores');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->string('email',255)->nullable();
            $table->string('password',255)->nullable();
            $table->string('password_salt',255)->nullable();
            $table->string('remember_token',255)->nullable();
            $table->integer('country')->unsigned()->nullable();
            $table->integer('state')->unsigned()->nullable();
            $table->integer('city')->unsigned()->nullable();
            $table->string('phone',255)->nullable();
            $table->string('address1',255)->nullable();
            $table->string('address2',255)->nullable();
            $table->double('commission')->nullable();
            $table->string('payment_account_details',255)->nullable();

            $table->string('store_name',255)->nullable();
            $table->string('store_phone',255)->nullable();
            $table->string('store_address1',255)->nullable();
            $table->string('store_address2',255)->nullable();
            $table->integer('store_country')->unsigned()->nullable();
            $table->integer('store_state')->unsigned()->nullable();
            $table->integer('store_city')->unsigned()->nullable();
            $table->integer('store_zipcode')->nullable();
            $table->string('meta_keyword',255)->nullable();
            $table->string('meta_description',255)->nullable();
            $table->string('website',255)->nullable();
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
        Schema::dropIfExists('merchants');
    }
}

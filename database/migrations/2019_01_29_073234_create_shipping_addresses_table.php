<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('first_name',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->string('contact_no',255)->nullable();
            $table->text('address',255)->nullable();
            $table->text('landmark',255)->nullable();
            $table->integer('city')->unsigned()->nullable();
            $table->integer('pincode')->nullable();
            $table->integer('state')->unsigned()->nullable();
            $table->integer('country')->unsigned()->nullable();
            $table->integer('is_block')->default(1)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('country')->references('id')->on('countries_managements')->onDelete('set null');
            $table->foreign('state')->references('id')->on('state_managements')->onDelete('set null');
            $table->foreign('city')->references('id')->on('city_managements')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_addresses');
    }
}

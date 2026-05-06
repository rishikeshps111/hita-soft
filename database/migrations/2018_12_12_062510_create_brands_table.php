<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brand_code',255)->nullable();
            $table->string('brand_name',255)->nullable();
            $table->string('brand_image',255)->nullable();
            $table->string('country_origin',255)->nullable();
            $table->string('address',255)->nullable();
            $table->integer('country')->unsigned()->nullable();
            $table->integer('state')->unsigned()->nullable();
            $table->integer('city')->unsigned()->nullable();
            $table->integer('pincode')->nullable();
            $table->integer('is_block')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('brands');
    }
}

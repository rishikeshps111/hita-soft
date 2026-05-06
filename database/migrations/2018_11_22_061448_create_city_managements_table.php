<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_managements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_name')->nullable();
            $table->integer('state')->nullable();
            $table->string('city_name',255)->nullable();
            $table->integer('default')->default(0)->nullable();
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
        Schema::dropIfExists('city_managements');
    }
}

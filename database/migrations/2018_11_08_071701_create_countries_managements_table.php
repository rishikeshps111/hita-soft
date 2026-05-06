<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries_managements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->nullable();
            $table->string('country_name',255)->nullable();
            $table->string('country_code',255)->nullable();
            $table->string('currency_symbol',255)->nullable();
            $table->string('currency_code',255)->nullable();
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
        Schema::dropIfExists('countries_managements');
    }
}

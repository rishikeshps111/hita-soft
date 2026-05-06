<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStateManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_managements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country')->unsigned()->nullable();
            $table->string('state',255)->nullable();
            $table->integer('default')->default(0)->nullable();
            $table->integer('is_block')->nullable();
            $table->timestamps();

            $table->foreign('country')->references('id')->on('countries_managements')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('state_managements');
    }
}

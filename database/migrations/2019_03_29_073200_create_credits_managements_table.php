<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditsManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits_managements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id')->unsigned()->nullable();
            $table->double('previous_credits',20,2)->default(0.00)->nullable();
            $table->double('current_credits',20,2)->default(0.00)->nullable();
            $table->double('add_credits',20,2)->default(0.00)->nullable();
            $table->longtext('remarks')->nullable();
            $table->timestamps();

            $table->foreign('merchant_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credits_managements');
    }
}

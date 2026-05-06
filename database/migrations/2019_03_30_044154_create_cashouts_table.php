<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('request_code',255)->nullable();
            $table->double('request_amount',20,2)->default(0.00)->nullable();
            $table->double('amount_paid',20,2)->default(0.00)->nullable();
            $table->double('balance',20,2)->default(0.00)->nullable();
            $table->date('request_date')->nullable();
            $table->integer('merchant_id')->unsigned()->nullable();
            $table->string('paid_status',255)->default('Unpaid')->nullable();
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
        Schema::dropIfExists('cashouts');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashoutPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashout_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_code')->unsigned()->nullable();
            $table->integer('bank')->unsigned()->nullable();
            $table->integer('pay_mode')->default(0)->nullable();
            $table->string('cheque_no', 255)->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->string('branch_name', 255)->nullable();
            $table->string('receipt', 255)->nullable();
            $table->timestamps();

            $table->foreign('request_code')->references('id')->on('cashouts')->onDelete('cascade');
            $table->foreign('bank')->references('id')->on('bank_details')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashout_payments');
    }
}

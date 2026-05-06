<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trans_code',255)->nullable();
            $table->date('trans_date')->nullable();
            $table->integer('order_id')->unsigned()->nullable();
            $table->double('net_amount')->nullable();
            $table->double('amountpaid')->nullable();
            $table->string('paymentmode',255)->nullable();
            $table->string('gatewaytransactionid',255)->nullable();
            $table->string('trans_status',255)->nullable();
            $table->longtext('remarks')->nullable();
            $table->integer('is_block')->default(1)->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_transactions');
    }
}

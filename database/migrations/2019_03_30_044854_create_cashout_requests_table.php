<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashoutRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashout_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_code')->unsigned()->nullable();
            $table->integer('order_code')->unsigned()->nullable();
            $table->integer('order_dets')->unsigned()->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('merchant_id')->unsigned()->nullable();
            $table->double('comis_amount', 20,2)->default(0.00)->nullable();
            $table->double('vendor_amount', 20,2)->default(0.00)->nullable();
            $table->longtext('remarks')->nullable();
            $table->timestamps();

            $table->foreign('request_code')->references('id')->on('cashouts')->onDelete('cascade');
            $table->foreign('order_code')->references('id')->on('orders')->onDelete('set null');
            $table->foreign('order_dets')->references('id')->on('order_details')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
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
        Schema::dropIfExists('cashout_requests');
    }
}

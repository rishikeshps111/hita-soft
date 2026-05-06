<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code')->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('att_name')->unsigned()->nullable();
            $table->integer('att_value')->unsigned()->nullable();
            $table->integer('previous_qty')->default(0)->nullable();
            $table->integer('current_qty')->default(0)->nullable();
            $table->integer('att_previous_qty')->default(0)->nullable();
            $table->integer('att_current_qty')->default(0)->nullable();
            $table->date('date')->nullable();
            $table->longtext('remarks')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('att_name')->references('id')->on('attributes_fields')->onDelete('set null');
            $table->foreign('att_value')->references('id')->on('attributes_settings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_transactions');
    }
}

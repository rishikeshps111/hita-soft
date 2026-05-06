<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('attribute')->unsigned()->nullable();
            $table->integer('stock')->unsigned()->nullable();
            $table->double('previous_qty')->default(0)->nullable();
            $table->double('current_qty')->default(0)->nullable();
            $table->double('addon_qty')->default(0)->nullable();
            $table->date('date')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('attribute')->references('id')->on('products_attributes')->onDelete('cascade');
            $table->foreign('stock')->references('id')->on('stock_managements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_stocks');
    }
}

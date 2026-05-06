<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferStockManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_stock_managements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('offer')->unsigned()->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('att_name')->unsigned()->nullable();
            $table->integer('att_value')->unsigned()->nullable();
            $table->double('offer_qty')->default(0)->nullable();
            $table->date('date')->nullable();
            $table->timestamps();

            $table->foreign('offer')->references('id')->on('offers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('offer_stock_managements');
    }
}

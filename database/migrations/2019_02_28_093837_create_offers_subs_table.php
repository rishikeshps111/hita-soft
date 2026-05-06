<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers_subs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('offer')->unsigned()->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('qty')->default(0)->nullable();
            $table->double('offer_price', 20, 2)->default(0.00)->nullable();
            $table->integer('type')->default(0)->nullable();
            $table->integer('is_block')->default(0)->nullable();
            $table->timestamps();

            $table->foreign('offer')->references('id')->on('offers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers_subs');
    }
}

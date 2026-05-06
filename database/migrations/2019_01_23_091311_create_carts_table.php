<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('name',255)->nullable();
            $table->double('qty')->nullable();
            $table->double('original_price',20,2)->default(0.00)->nullable();
            $table->double('price',20,2)->default(0.00)->nullable();
            $table->double('total_price',20,2)->default(0.00)->nullable();
            $table->double('tax_amount',20,2)->default(0.00)->nullable();
            $table->double('cod_charge',20,2)->default(0.00)->nullable();
            $table->string('image',255)->nullable();
            $table->longtext('notes')->nullable();
            $table->string('is_offer', 255)->default('No')->nullable();
            $table->integer('offer_id')->unsigned()->nullable();
            $table->integer('offer_det_id')->unsigned()->nullable();
            $table->string('cart_key', 255)->nullable();
            $table->string('cart_del', 255)->nullable();
            $table->integer('is_block')->default(1)->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->foreign('offer_det_id')->references('id')->on('offers_subs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('attribute_name')->unsigned()->nullable();
            $table->integer('attribute_values')->unsigned()->nullable();
            $table->string('colors',255)->nullable();
            $table->string('sizes',255)->nullable();
            $table->string('capacity',255)->nullable();
            $table->double('att_cost',20,2)->nullable();
            $table->double('att_tax_amount',20,2)->nullable();
            $table->float('att_price',20,2)->nullable();
            $table->longtext('description')->nullable();
            $table->integer('parameters')->nullable();
            $table->string('image',255)->nullable();
            $table->integer('is_block')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('attribute_name')->references('id')->on('attributes_fields')->onDelete('set null');
            $table->foreign('attribute_values')->references('id')->on('attributes_settings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_attributes');
    }
}

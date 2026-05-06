<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrvOrdersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grv_orders_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grv_id')->unsigned()->nullable();
            $table->integer('rtn_odr_det_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->string('product_title',255)->nullable();
            $table->integer('att_name')->unsigned()->nullable();
            $table->integer('att_value')->unsigned()->nullable();
            $table->double('tax', 20, 2)->default(0.00)->nullable();
            $table->integer('tax_type')->default(0)->nullable();
            $table->double('order_qty')->nullable();
            $table->double('unitprice')->nullable();
            $table->double('totalprice')->nullable();
            $table->string('return_type',255)->nullable();
            $table->double('return_qty')->nullable();
            $table->double('return_amount')->nullable();
            $table->longtext('reason')->nullable();
            $table->longtext('remarks')->nullable();
            $table->string('rtn_image',255)->nullable();
            $table->string('grv_issued',255)->default('No')->nullable();
            $table->timestamps();

            $table->foreign('grv_id')->references('id')->on('grv_orders')->onDelete('cascade');
            $table->foreign('rtn_odr_det_id')->references('id')->on('return_order_details')->onDelete('set null');
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
        Schema::dropIfExists('grv_orders_details');
    }
}

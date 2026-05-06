<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code',255)->nullable();
            $table->date('order_date')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('payment_mode',255)->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->string('order_status',255)->nullable();
            $table->date('cancel_date')->nullable();
            $table->integer('cancel_approved')->default(0)->nullable();
            $table->string('contact_person',255)->nullable();
            $table->string('contact_no',255)->nullable();
            $table->integer('shipping_address_flag')->default(0);
            $table->text('shipping_address')->nullable();
            $table->string('city',255)->nullable();
            $table->integer('pincode')->nullable();
            $table->double('total_items')->nullable();
            $table->integer('discount_flag')->nullable();
            $table->double('discount')->nullable();
            $table->double('shipping_charge')->nullable();
            $table->double('cod_charge',20,2)->default(0.00)->nullable();
            $table->double('net_amount')->nullable();
            $table->integer('payment_status')->nullable();
            $table->integer('delivery_status')->nullable();
            $table->longtext('remarks')->nullable();
            $table->integer('status_flag')->nullable();
            $table->integer('return_order_status')->default(0)->nullable();
            $table->string('replace_order')->default('No')->nullable();
            $table->integer('grv_id')->unsigned()->nullable();
            $table->integer('ref_order_id')->unsigned()->nullable();
            $table->integer('is_block')->default(1)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('grv_id')->references('id')->on('grv_orders')->onDelete('set null');
            $table->foreign('ref_order_id')->references('id')->on('orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

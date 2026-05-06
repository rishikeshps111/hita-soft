<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grv_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('grv_code', 255)->nullable();
            $table->integer('order_id')->unsigned()->nullable();
            $table->integer('return_order_id')->unsigned()->nullable();
            $table->longtext('grv_remarks')->nullable();
            $table->integer('grv_status')->default(0)->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('return_order_id')->references('id')->on('return_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grv_orders');
    }
}

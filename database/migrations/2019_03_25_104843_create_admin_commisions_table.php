<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminCommisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_commisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code')->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('merchant_id')->unsigned()->nullable();
            $table->double('amount',20,2)->default(0.00)->nullable();
            $table->integer('paid_status')->default(0)->nullable();
            $table->longtext('remarks')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('admin_commisions');
    }
}

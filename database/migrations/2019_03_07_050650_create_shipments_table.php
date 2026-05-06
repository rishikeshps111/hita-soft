<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code')->nullable();
            $table->string('shipment_id',255)->nullable();
            $table->date('shipment_date')->nullable();
            $table->double('value',20,2)->nullable();
            $table->double('weight',20,2)->nullable();
            $table->string('type',255)->nullable();
            $table->string('mode_type',255)->nullable();
            $table->string('carrier',255)->nullable();
            $table->string('awb',255)->nullable();
            $table->string('shiping_status',255)->nullable();
            $table->double('delivery_charges',20,2)->nullable();
            $table->date('delivery_date')->nullable();
            $table->longtext('ship_remarks')->nullable();
            $table->integer('courier_payment_status')->default(0);
            $table->longtext('courier_payment_remarks')->nullable();
            $table->integer('is_block')->default(1)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
}

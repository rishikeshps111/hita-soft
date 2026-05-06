<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminCashoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_cashouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor')->unsigned()->nullable();
            $table->string('process_type', 255)->default('Deduction')->nullable();
            $table->double('amount', 20, 2)->default(0.00)->nullable();
            $table->integer('credit_note')->unsigned()->nullable();
            $table->integer('order_id')->unsigned()->nullable();
            $table->longtext('reasons')->nullable();
            $table->longtext('others')->nullable();
            $table->longtext('remarks')->nullable();
            $table->longtext('vendor_remarks')->nullable();
            $table->timestamps();

            $table->foreign('vendor')->references('id')->on('users')->onDelete('set null');
            $table->foreign('credit_note')->references('id')->on('credits_notes')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_cashouts');
    }
}

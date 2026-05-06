<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id')->unsigned()->nullable();
            $table->string('ac_no',255)->nullable();
            $table->string('ac_name',255)->nullable();
            $table->string('bank_name',255)->nullable();
            $table->string('bank_branch',255)->nullable();
            $table->string('bank_ifsc',255)->nullable();
            $table->integer('default')->default(0);
            $table->longtext('remarks')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('bank_details');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('is_taxable')->default(0)->nullable();
            $table->string('vat_gst_no', 255)->nullable();
            $table->string('primary_acc_type', 255)->nullable();
            $table->string('primary_acc_no', 255)->nullable();
            $table->string('primary_acc_holder_name', 255)->nullable();
            $table->string('primary_acc_bank', 255)->nullable();
            $table->string('primary_acc_branch', 255)->nullable();
            $table->string('primary_acc_ifsc', 255)->nullable();
            $table->string('optional_acc_type', 255)->nullable();
            $table->string('optional_acc_no', 255)->nullable();
            $table->string('optional_acc_holder_name', 255)->nullable();
            $table->string('optional_acc_bank', 255)->nullable();
            $table->string('optional_acc_branch', 255)->nullable();
            $table->string('optional_acc_ifsc', 255)->nullable();
            $table->double('initial_credits', 255)->nullable();
            $table->integer('is_block')->default(0)->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('account_settings');
    }
}

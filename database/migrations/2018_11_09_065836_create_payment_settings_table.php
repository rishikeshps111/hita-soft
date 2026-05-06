<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->nullable();
            $table->string('country_name',255)->nullable();
            $table->string('country_code',255)->nullable();
            $table->string('currency_symbol',255)->nullable();
            $table->string('currency_code',255)->nullable();
            $table->string('paypal_account',255)->nullable();
            $table->string('paypal_api_password',255)->nullable();
            $table->string('paypal_api_signature',255)->nullable();
            $table->string('payUmoney_key',255)->nullable();
            $table->string('payUmoney_salt',255)->nullable();
            $table->string('cash_free_api',255)->nullable();
            $table->string('cash_free_secret',255)->nullable();
            $table->integer('payment_mode')->nullable();
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
        Schema::dropIfExists('payment_settings');
    }
}

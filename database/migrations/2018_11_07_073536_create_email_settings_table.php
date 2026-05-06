<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contact_name',255)->nullable();
            $table->string('contact_email',255)->nullable();
            $table->string('skype_email',255)->nullable();
            $table->string('webmaster_email',255)->nullable();
            $table->string('site_no_reply_email',255)->nullable();
            $table->string('contact_phone1',255)->nullable();
            $table->string('contact_phone2',255)->nullable();
            $table->string('contact_phone2',255)->nullable();
            $table->string('address1',255)->nullable();
            $table->string('address2',255)->nullable();
            $table->string('pincode',255)->nullable();
            $table->integer('country')->unsigned()->nullable();
            $table->integer('state')->unsigned()->nullable();
            $table->integer('city')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('country')->references('id')->on('countries_managements')->onDelete('set null');
            $table->foreign('state')->references('id')->on('state_managements')->onDelete('set null');
            $table->foreign('city')->references('id')->on('city_managements')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_settings');
    }
}

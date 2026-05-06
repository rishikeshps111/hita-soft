<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->string('bussiness_name',255)->nullable();
            $table->string('buss_reg_no',255)->nullable();
            $table->string('email',255)->nullable();
            $table->string('password',255)->nullable();
            $table->string('password_salt',255)->nullable();
            $table->string('profile_img',255)->nullable();
            $table->string('remember_token',255)->nullable();
            $table->integer('country')->unsigned()->nullable();
            $table->integer('state')->unsigned()->nullable();
            $table->integer('city')->unsigned()->nullable();
            $table->integer('pincode')->nullable();
            $table->string('phone',255)->nullable();
            $table->string('phone2',255)->nullable();
            $table->string('gender',255)->nullable();
            $table->string('address1',255)->nullable();
            $table->string('address2',255)->nullable();
            $table->string('address2',255)->nullable();
            $table->string('landmark',255)->nullable();
            $table->double('commission')->nullable();
            $table->string('payment_account_details',255)->nullable();
            $table->string('verification',255)->nullable();
            $table->integer('is_approved')->nullable();
            $table->integer('is_block')->nullable();
            $table->integer('user_type')->nullable();
            $table->integer('login_type')->nullable();
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
        Schema::dropIfExists('users');
    }
}

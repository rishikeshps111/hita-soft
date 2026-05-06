<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant')->unsigned()->nullable();
            $table->string('d_name',255)->nullable();
            $table->string('image',255)->nullable();
            $table->integer('is_block')->nullable();
            $table->timestamps();

            $table->foreign('merchant')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants_documents');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('att_name')->unsigned()->nullable();
            $table->string('att_value', 255)->nullable();
            $table->string('att_image', 255)->nullable();
            $table->longtext('att_desc')->nullable();
            $table->integer('is_block')->default(0)->nullable();
            $table->timestamps();

            $table->foreign('att_name')->references('id')->on('attributes_fields')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes_settings');
    }
}

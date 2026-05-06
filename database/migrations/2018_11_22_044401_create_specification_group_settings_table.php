<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecificationGroupSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specification_group_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('main_cat_name')->unsigned()->nullable();
            $table->integer('sub_cat_name')->unsigned()->nullable();
            $table->integer('filter')->nullable();
            $table->string('group_name',255)->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('is_block')->nullable();
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
        Schema::dropIfExists('specification_group_settings');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_managements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('main_cat_name')->unsigned()->nullable();
            $table->double('tax')->nullable();
            $table->integer('is_block')->default(1)->nullable();
            $table->timestamps();

            $table->foreign('main_cat_name')->references('id')->on('category_management_settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_managements');
    }
}

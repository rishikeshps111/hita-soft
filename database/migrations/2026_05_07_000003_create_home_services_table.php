<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeServicesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('home_services')) {
            Schema::create('home_services', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title', 255)->nullable();
                $table->text('description')->nullable();
                $table->string('image', 255)->nullable();
                $table->integer('priority')->nullable();
                $table->tinyInteger('is_block')->default(1);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('home_services');
    }
}

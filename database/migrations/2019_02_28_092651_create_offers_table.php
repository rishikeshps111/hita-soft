<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('offer_title', 255)->nullable();
            $table->string('offer_type', 255)->nullable();
            $table->datetime('offer_start')->nullable();
            $table->datetime('offer_end')->nullable();
            $table->longtext('description', 255)->nullable();
            $table->longtext('grab_offer', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->integer('x_pro_cnt')->default(0)->nullable();
            $table->integer('y_pro_cnt')->default(0)->nullable();
            $table->integer('is_block')->default(0)->nullable();
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
        Schema::dropIfExists('offers');
    }
}

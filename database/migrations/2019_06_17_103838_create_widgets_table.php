<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_title', 255)->nullable();
            $table->string('first_content', 255)->nullable();
            $table->string('first_url', 255)->nullable();
            $table->string('first_icon', 255)->nullable();
            $table->string('second_title', 255)->nullable();
            $table->string('second_content', 255)->nullable();
            $table->string('second_url', 255)->nullable();
            $table->string('second_icon', 255)->nullable();
            $table->string('third_title', 255)->nullable();
            $table->string('third_content', 255)->nullable();
            $table->string('third_url', 255)->nullable();
            $table->string('third_icon', 255)->nullable();
            $table->string('fourth_title', 255)->nullable();
            $table->string('fourth_content', 255)->nullable();
            $table->string('fourth_url', 255)->nullable();
            $table->string('fourth_icon', 255)->nullable();
            $table->string('fifth_title', 255)->nullable();
            $table->string('fifth_content', 255)->nullable();
            $table->string('fifth_url', 255)->nullable();
            $table->string('fifth_icon', 255)->nullable();
            $table->string('provide_img', 255)->nullable();
            $table->string('provide_url', 255)->nullable();
            $table->string('footer_pay_img', 255)->nullable();
            $table->string('footer_pay_url', 255)->nullable();
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
        Schema::dropIfExists('widgets');
    }
}

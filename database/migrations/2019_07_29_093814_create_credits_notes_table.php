<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditsNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cn_code', 255)->nullable();
            $table->integer('grv_id')->unsigned()->nullable();
            $table->double('amount', 20, 2)->default(0.00)->nullable();
            $table->date('date')->nullable();
            $table->longtext('remarks')->nullable();
            $table->string('is_paid', 255)->default('Un Paid')->nullable();
            $table->timestamps();

            $table->foreign('grv_id')->references('id')->on('grv_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credits_notes');
    }
}

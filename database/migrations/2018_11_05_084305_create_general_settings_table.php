<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('site_name')->nullable();
            $table->text('site_description')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('cod')->nullable()->default(0);
            $table->integer('paypal')->nullable()->default(0);
            $table->integer('pay_Umoney')->nullable()->default(0);
            $table->string('frontend_url',255)->nullable();
            $table->string('backend_url',255)->nullable();
            $table->string('play_store_url',255)->nullable();
            $table->string('ios_store_url',255)->nullable();
            $table->longtext('cancel_terms')->nullable();
            $table->longtext('return_terms')->nullable();
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
        Schema::dropIfExists('general_settings');
    }
}

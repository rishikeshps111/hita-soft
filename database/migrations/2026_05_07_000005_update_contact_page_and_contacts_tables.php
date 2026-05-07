<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContactPageAndContactsTables extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('contact_us_page')) {
            Schema::create('contact_us_page', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
            });
        }

        Schema::table('contact_us_page', function (Blueprint $table) {
            $columns = [
                'banner_title' => 'string',
                'banner_image' => 'string',
                'form_intro' => 'text',
                'address' => 'text',
                'email' => 'string',
                'phone' => 'string',
                'map_iframe' => 'longText',
            ];

            foreach ($columns as $column => $type) {
                if (!Schema::hasColumn('contact_us_page', $column)) {
                    if ($type === 'string') {
                        $table->string($column, 255)->nullable();
                    } elseif ($type === 'text') {
                        $table->text($column)->nullable();
                    } else {
                        $table->longText($column)->nullable();
                    }
                }
            }
        });

        if (Schema::hasTable('contacts') && !Schema::hasColumn('contacts', 'subject')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('subject', 255)->nullable()->after('contact_no');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('contacts') && Schema::hasColumn('contacts', 'subject')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropColumn('subject');
            });
        }

        if (Schema::hasTable('contact_us_page')) {
            Schema::table('contact_us_page', function (Blueprint $table) {
                foreach (['banner_title', 'banner_image', 'form_intro', 'address', 'email', 'phone', 'map_iframe'] as $column) {
                    if (Schema::hasColumn('contact_us_page', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
}

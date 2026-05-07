<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewAboutPageFieldsToAboutUsCMSSettingsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('about_us_c_m_s_settings')) {
            return;
        }

        Schema::table('about_us_c_m_s_settings', function (Blueprint $table) {
            $columns = [
                'banner_title' => 'string',
                'banner_image' => 'string',
                'who_title' => 'string',
                'who_image' => 'string',
                'who_content' => 'longText',
                'what_title' => 'string',
                'what_content' => 'text',
                'what_items' => 'longText',
                'what_image' => 'string',
                'mission_title' => 'string',
                'mission_content' => 'text',
                'vision_title' => 'string',
                'vision_content' => 'text',
                'core_values_title' => 'string',
                'core_values' => 'longText',
                'leadership_bg_image' => 'string',
                'leadership_label' => 'string',
                'leadership_name' => 'string',
                'leadership_designation' => 'string',
                'leadership_content' => 'text',
                'presence_label' => 'string',
                'presence_name' => 'string',
                'presence_address' => 'text',
                'presence_phone' => 'string',
                'presence_email' => 'string',
            ];

            foreach ($columns as $column => $type) {
                if (!Schema::hasColumn('about_us_c_m_s_settings', $column)) {
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
    }

    public function down()
    {
        if (!Schema::hasTable('about_us_c_m_s_settings')) {
            return;
        }

        Schema::table('about_us_c_m_s_settings', function (Blueprint $table) {
            $columns = [
                'banner_title',
                'banner_image',
                'who_title',
                'who_image',
                'who_content',
                'what_title',
                'what_content',
                'what_items',
                'what_image',
                'mission_title',
                'mission_content',
                'vision_title',
                'vision_content',
                'core_values_title',
                'core_values',
                'leadership_bg_image',
                'leadership_label',
                'leadership_name',
                'leadership_designation',
                'leadership_content',
                'presence_label',
                'presence_name',
                'presence_address',
                'presence_phone',
                'presence_email',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('about_us_c_m_s_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}

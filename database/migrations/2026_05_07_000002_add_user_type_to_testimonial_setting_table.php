<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserTypeToTestimonialSettingTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('testimonial_setting') && !Schema::hasColumn('testimonial_setting', 'user_type')) {
            Schema::table('testimonial_setting', function (Blueprint $table) {
                $table->string('user_type', 255)->nullable()->after('name');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('testimonial_setting') && Schema::hasColumn('testimonial_setting', 'user_type')) {
            Schema::table('testimonial_setting', function (Blueprint $table) {
                $table->dropColumn('user_type');
            });
        }
    }
}

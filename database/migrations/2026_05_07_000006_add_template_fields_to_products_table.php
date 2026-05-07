<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplateFieldsToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'short_description')) {
                $table->text('short_description')->nullable()->after('product_desc');
            }

            if (!Schema::hasColumn('products', 'product_capacity')) {
                $table->string('product_capacity')->nullable()->after('features');
            }

            if (!Schema::hasColumn('products', 'product_type')) {
                $table->string('product_type')->nullable()->after('product_capacity');
            }

            if (!Schema::hasColumn('products', 'product_power')) {
                $table->string('product_power')->nullable()->after('product_type');
            }

            if (!Schema::hasColumn('products', 'product_size')) {
                $table->string('product_size')->nullable()->after('product_power');
            }

            if (!Schema::hasColumn('products', 'product_feature_text')) {
                $table->text('product_feature_text')->nullable()->after('product_size');
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = [
                'short_description',
                'product_capacity',
                'product_type',
                'product_power',
                'product_size',
                'product_feature_text',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}

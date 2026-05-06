<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_code',255)->nullable();
            $table->string('product_title',255)->nullable();
            $table->longtext('product_desc')->nullable();
            $table->double('product_weight')->nullable()->default(0);
            $table->double('product_length')->nullable()->default(0);
            $table->double('product_width')->nullable()->default(0);
            $table->double('product_height')->nullable()->default(0);
            $table->string('vendor_code',255)->nullable();
            $table->integer('brand')->unsigned()->nullable();
            $table->string('model_no',255)->nullable();
            $table->string('varient',255)->nullable();
            $table->integer('main_cat_name')->unsigned()->nullable();
            $table->integer('sub_cat_name')->unsigned()->nullable();
            $table->integer('sub_sub_cat_name')->unsigned()->nullable();
            $table->string('manufacturer',255)->nullable();
            $table->string('tags',255)->nullable();
            $table->float('original_price',20,2)->nullable();
            $table->float('tax',20,2)->nullable();
            $table->double('product_cost',20,2)->nullable();
            $table->double('tax_amount',20,2)->nullable();
            $table->float('discounted_price',20,2)->nullable();
            $table->float('service_charge',20,2)->nullable();
            $table->float('shiping_charge',20,2)->nullable();
            $table->integet('tax_type')->nullable();
            $table->integer('onhand_qty')->nullable();
            $table->integer('measurement_unit')->unsigned()->nullable();
            $table->string('features',255)->nullable();
            $table->integer('attributes_flag')->nullable()->default(0);
            $table->string('featured_product_img',255)->nullable();
            $table->integer('offers_flag')->nullable()->default(0);
            $table->integer('featuredproduct_flag')->nullable()->default(0);
            $table->integer('toprated_flag')->nullable()->default(0);
            $table->integer('best_seller_flag')->nullable()->default(0);
            $table->integer('created_user')->nullable();
            $table->integer('modified_user')->nullable();
            $table->integer('delivery')->nullable();
            $table->integer('store')->nullable();
            $table->integer('is_block')->nullable()->default(0);
            $table->timestamps();

            $table->foreign('brand')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('main_cat_name')->references('id')->on('category_management_settings')->onDelete('set null');
            $table->foreign('sub_cat_name')->references('sub_cat_id')->on('sub_category_management_settings')->onDelete('set null');
            $table->foreign('sub_sub_cat_name')->references('sub_sub_cat_id')->on('sub_sub_category_management_settings')->onDelete('set null');
            $table->foreign('measurement_unit')->references('id')->on('measurement_units')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

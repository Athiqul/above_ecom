<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->string('product_name');
            $table->string('product_slug');
            $table->string('product_code');
            $table->string('product_qty');
            $table->string('product_tags')->nullable();
            $table->string('product_size')->nullable();
            $table->string('product_color')->nullable();
            $table->integer('selling_price');
            $table->integer('discount_price')->nullable();
            $table->text('short_desc');
            $table->text('long_desc');
            $table->string('main_image');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->enum('hot_deals',['0','1'])->default('0');
            $table->enum('featured',['0','1'])->default('0');
            $table->enum('special_offer',['0','1'])->default('0');
            $table->enum('special_deals',['0','1'])->default('0');
            $table->enum('status',['0','1'])->default('0');
            $table->timestamps();
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('subcategory_id')->references('id')->on('sub_categories');
            $table->foreign('vendor_id')->references('id')->on('vendor_infos');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

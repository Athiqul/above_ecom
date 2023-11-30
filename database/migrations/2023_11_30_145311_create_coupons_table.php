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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code');
            $table->enum('discount_type',['percent','amount'])->default('amount');
            $table->unsignedInteger('discount_amount');
            $table->unsignedInteger('min_purchase_amount')->nullable();
            $table->unsignedInteger('max_discount_amount')->nullable();
            $table->date('start_date')->nullable();
            $table->date('last_date');
            $table->enum('status',['0','1'])->default('1');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('limit')->nullable();
            $table->integer('count')->default(0);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

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
        Schema::create('delivery_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_product_estimation_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
        
            $table->foreign('delivery_product_estimation_id')
                  ->references('id')
                  ->on('delivery_product_estimations')
                  ->onDelete('cascade');
        
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        
            $table->unique(['delivery_product_estimation_id', 'product_id'], 'delivery_product_estimation_product_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_product');
    }
};

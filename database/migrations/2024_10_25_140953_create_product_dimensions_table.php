<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('product_dimensions', function (Blueprint $table) {

            $table->foreignId('product_id')->unique()->constrained('products')->cascadeOnDelete();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('length')->nullable();
            $table->string('capacity')->nullable();
            $table->string('noise_level')->nullable();
            $table->string('weight')->nullable();
            $table->string('power_consumption')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_dimensions');
    }
};

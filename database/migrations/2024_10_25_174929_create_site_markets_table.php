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
        Schema::create('site_markets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('site_settings')->cascadeOnDelete();
            $table->string('market');
            $table->string('address');
            $table->timestamps();

            $table->unique(['site_id', 'market']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_markets');
    }
};

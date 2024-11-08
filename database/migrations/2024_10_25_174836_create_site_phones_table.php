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
        Schema::create('site_phones', function (Blueprint $table) {

            $table->foreignId('site_id')->constrained('site_settings')->cascadeOnDelete();
            $table->string('phone');
            $table->timestamps();

            $table->unique(['site_id', 'phone']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_phones');
    }
};

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
        Schema::create('product_faq_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_id')->constrained('product_faqs')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->text('question');
            $table->text('answer');
            $table->timestamps();

            $table->unique(['faq_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_faq_translations');
    }
};

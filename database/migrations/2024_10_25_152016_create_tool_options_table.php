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
        Schema::create('tool_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained('tools')->cascadeOnDelete(); // links to specific tool
            $table->string('building_type')->nullable();
            $table->integer('rooms')->nullable();
            $table->string('platform')->nullable();
            $table->string('system_type')->nullable();
            $table->string('package')->nullable();
            $table->string('installed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool_options');
    }
};

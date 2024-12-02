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
        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropUnique('subcategories_name_unique');
            $table->dropUnique('subcategories_ar_name_unique');
            $table->unique(['name', 'category_id'], 'subcategories_name_category_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subcategories', function (Blueprint $table) {

            $table->dropUnique('subcategories_name_category_id_unique');
            $table->unique('name', 'subcategories_name_unique');
            $table->unique('ar_name', 'subcategories_ar_name_unique');
        });
    }
};

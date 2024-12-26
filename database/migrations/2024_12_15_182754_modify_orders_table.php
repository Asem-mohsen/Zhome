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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('session_id')->nullable()->after('user_id')->change();
            $table->string('transaction_id')->nullable()->after('session_id')->change();

            $table->dropForeign(['product_id']);

            $table->dropIndex('product_id'); 
 
             $table->dropColumn(['product_id', 'quantity', 'is_on_sale', 'with_instllation', 'price']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->unsigned();
            $table->boolean('is_on_sale')->default(false);
            $table->boolean('with_installation')->default(false);
            $table->decimal('price', 10, 2);

            $table->dropColumn(['session_id', 'transaction_id']);
        });


    }
};

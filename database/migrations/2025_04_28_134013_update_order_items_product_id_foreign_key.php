<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Drop the existing foreign key constraint
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        // Recreate the foreign key with onDelete('cascade')
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('product_id')->change()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop the foreign key with cascade
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        // Restore the original foreign key without cascade
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('product_id')->change()->constrained();
        });
    }
};
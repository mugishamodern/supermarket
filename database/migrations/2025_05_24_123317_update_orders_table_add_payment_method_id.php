<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the existing payment_method column
            $table->dropColumn('payment_method');
            // Add payment_method_id foreign key
            $table->foreignId('payment_method_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null')
                  ->after('status');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['payment_method_id']);
            $table->dropColumn('payment_method_id');
            $table->string('payment_method')->after('status');
        });
    }
};
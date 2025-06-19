<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('products', 'images')) {
            Schema::table('products', function (Blueprint $table) {
                $table->text('images')->nullable();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('products', 'images')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('images');
            });
        }
    }
}; 
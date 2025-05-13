<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndRepliedAtToContactInquiriesTable extends Migration
{
    public function up()
    {
        Schema::table('contact_inquiries', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('message');
            $table->timestamp('replied_at')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('contact_inquiries', function (Blueprint $table) {
            $table->dropColumn(['status', 'replied_at']);
        });
    }
}
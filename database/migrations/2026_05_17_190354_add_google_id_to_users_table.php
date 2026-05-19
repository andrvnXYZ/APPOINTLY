<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable();        // ✅ ADD THIS
            $table->string('microsoft_id')->nullable();     // ✅ ADD THIS
            $table->string('microsoft_token')->nullable();  // ✅ ADD THIS
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_id');
            $table->dropColumn('microsoft_id');
            $table->dropColumn('microsoft_token');
        });
    }
};
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
        Schema::table('bookings_222142', function (Blueprint $table) {
            $table->string('qr_code_222142')->nullable()->after('status_222142');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings_222142', function (Blueprint $table) {
            $table->dropColumn('qr_code_222142');
        });
    }
};

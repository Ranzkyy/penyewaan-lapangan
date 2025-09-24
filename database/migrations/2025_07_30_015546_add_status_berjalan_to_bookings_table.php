<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings_222142', function (Blueprint $table) {
            // Update the enum to include 'berjalan' status
            DB::statement("ALTER TABLE bookings_222142 MODIFY COLUMN status_222142 ENUM('aktif', 'tidak aktif', 'proses', 'berjalan')");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings_222142', function (Blueprint $table) {
            // Revert back to original enum
            DB::statement("ALTER TABLE bookings_222142 MODIFY COLUMN status_222142 ENUM('aktif', 'tidak aktif', 'proses')");
        });
    }
};

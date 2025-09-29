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
        // Update the enum to include 'selesai' status
        DB::statement("ALTER TABLE bookings_222142 MODIFY COLUMN status_222142 ENUM('aktif', 'tidak aktif', 'proses', 'berjalan', 'selesai') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum without 'selesai'
        DB::statement("ALTER TABLE bookings_222142 MODIFY COLUMN status_222142 ENUM('aktif', 'tidak aktif', 'proses', 'berjalan') NOT NULL");
    }
};
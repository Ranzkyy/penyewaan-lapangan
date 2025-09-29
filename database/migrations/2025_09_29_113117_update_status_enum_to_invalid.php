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
        // First, add 'invalid' to the enum
        DB::statement("ALTER TABLE bookings_222142 MODIFY COLUMN status_222142 ENUM('aktif', 'tidak aktif', 'proses', 'berjalan', 'selesai', 'terlewat', 'invalid') NOT NULL");
        
        // Then update any existing 'terlewat' records to 'invalid'
        DB::statement("UPDATE bookings_222142 SET status_222142 = 'invalid' WHERE status_222142 = 'terlewat'");
        
        // Finally, remove 'terlewat' from the enum
        DB::statement("ALTER TABLE bookings_222142 MODIFY COLUMN status_222142 ENUM('aktif', 'tidak aktif', 'proses', 'berjalan', 'selesai', 'invalid') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to 'terlewat'
        DB::statement("ALTER TABLE bookings_222142 MODIFY COLUMN status_222142 ENUM('aktif', 'tidak aktif', 'proses', 'berjalan', 'selesai', 'terlewat') NOT NULL");
    }
};
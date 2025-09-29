<?php

namespace App\Console\Commands;

use App\Models\booking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoCompleteBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:auto-complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically complete bookings that have passed their end time and mark expired bookings as invalid';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting auto-complete bookings process...');
        
        // Get current time in Asia/Kuala_Lumpur timezone
        $now = Carbon::now('Asia/Kuala_Lumpur');
        
        // 1. Find all bookings with status 'berjalan' that have passed their end time
        $expiredRunningBookings = booking::where('status_222142', 'berjalan')
            ->where(function($query) use ($now) {
                $query->where('tgl_booking_222142', '<', $now->format('Y-m-d'))
                      ->orWhere(function($subQuery) use ($now) {
                          $subQuery->where('tgl_booking_222142', $now->format('Y-m-d'))
                                   ->where('jam_selesai_222142', '<', $now->format('H:i:s'));
                      });
            })
            ->get();
        
        $completedCount = 0;
        
        foreach ($expiredRunningBookings as $booking) {
            // Create booking end time for comparison
            $bookingEnd = Carbon::createFromFormat(
                'Y-m-d H:i:s', 
                $booking->tgl_booking_222142 . ' ' . $booking->jam_selesai_222142, 
                'Asia/Kuala_Lumpur'
            );
            
            // Double check if booking has actually ended
            if ($now > $bookingEnd) {
                $booking->status_222142 = 'selesai';
                $booking->save();
                
                $completedCount++;
                
                $this->line("✅ Completed booking ID: {$booking->id} - {$booking->tgl_booking_222142} {$booking->jam_selesai_222142}");
            }
        }
        
        // 2. Find all bookings with status 'aktif' that have passed their end time (terlewat)
        $expiredActiveBookings = booking::where('status_222142', 'aktif')
            ->where(function($query) use ($now) {
                $query->where('tgl_booking_222142', '<', $now->format('Y-m-d'))
                      ->orWhere(function($subQuery) use ($now) {
                          $subQuery->where('tgl_booking_222142', $now->format('Y-m-d'))
                                   ->where('jam_selesai_222142', '<', $now->format('H:i:s'));
                      });
            })
            ->get();
        
        $expiredCount = 0;
        
        foreach ($expiredActiveBookings as $booking) {
            // Create booking end time for comparison
            $bookingEnd = Carbon::createFromFormat(
                'Y-m-d H:i:s', 
                $booking->tgl_booking_222142 . ' ' . $booking->jam_selesai_222142, 
                'Asia/Kuala_Lumpur'
            );
            
            // Double check if booking has actually ended
            if ($now > $bookingEnd) {
                $booking->status_222142 = 'invalid';
                $booking->save();
                
                $expiredCount++;
                
                $this->line("❌ Invalid booking ID: {$booking->id} - {$booking->tgl_booking_222142} {$booking->jam_selesai_222142}");
            }
        }
        
        // Summary
        if ($completedCount > 0) {
            $this->info("🎉 Successfully completed {$completedCount} booking(s)");
        }
        
        if ($expiredCount > 0) {
            $this->info("❌ Marked {$expiredCount} booking(s) as invalid");
        }
        
        if ($completedCount == 0 && $expiredCount == 0) {
            $this->info("ℹ️  No bookings found that need to be updated");
        }
        
        $this->info('Auto-complete bookings process finished.');
        
        return Command::SUCCESS;
    }
}
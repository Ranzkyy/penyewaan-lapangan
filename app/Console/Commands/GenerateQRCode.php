<?php

namespace App\Console\Commands;

use App\Models\booking;
use Illuminate\Console\Command;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQRCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:generate {booking_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate QR code for booking';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bookingId = $this->argument('booking_id');

        if ($bookingId) {
            // Generate QR code for specific booking
            $booking = booking::find($bookingId);
            if (!$booking) {
                $this->error("Booking dengan ID {$bookingId} tidak ditemukan!");
                return 1;
            }

            $this->generateQRForBooking($booking);
        } else {
            // Generate QR codes for all active bookings without QR code
            $bookings = booking::where('status_222142', 'aktif')
                              ->whereNull('qr_code_222142')
                              ->get();

            if ($bookings->isEmpty()) {
                $this->info('Tidak ada booking aktif yang memerlukan QR code.');
                return 0;
            }

            $this->info("Menemukan {$bookings->count()} booking yang memerlukan QR code.");
            
            $bar = $this->output->createProgressBar($bookings->count());
            $bar->start();

            foreach ($bookings as $booking) {
                $this->generateQRForBooking($booking);
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info('QR code berhasil dibuat untuk semua booking!');
        }

        return 0;
    }

    private function generateQRForBooking($booking)
    {
        // Generate QR code data
        $qrData = json_encode([
            'booking_id' => $booking->id,
            'user_id' => $booking->id_user,
            'lapangan_id' => $booking->id_lapangan,
            'tanggal' => $booking->tgl_booking_222142,
            'jam_mulai' => $booking->jam_mulai_222142,
            'jam_selesai' => $booking->jam_selesai_222142,
            'status' => $booking->status_222142,
            'total' => $booking->total_222142,
            'timestamp' => now()->toISOString()
        ]);

        // Generate QR code filename
        $qrCodeFilename = 'qr_code_' . $booking->id . '_' . time() . '.svg';
        
        // Generate and save QR code
        $qrCode = QrCode::size(300)
                       ->format('svg')
                       ->backgroundColor(255, 255, 255)
                       ->color(0, 0, 0)
                       ->generate($qrData);
        
        // Save QR code to public/images directory
        file_put_contents(public_path('images/' . $qrCodeFilename), $qrCode);
        
        // Generate referral code
        $referralCode = 'BK' . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(substr(md5($booking->id . time()), 0, 4));
        
        // Update booking record
        $booking->qr_code_222142 = $qrCodeFilename;
        $booking->referral_code_222142 = $referralCode;
        $booking->save();

        $this->info("QR code dan referral code berhasil dibuat untuk booking ID: {$booking->id}");
    }
}

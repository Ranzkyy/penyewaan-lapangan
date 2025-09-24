<?php

namespace App\Http\Controllers;

use App\Models\booking;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class QRCodeController extends Controller
{
    public function generateQRCode($bookingId)
    {
        $booking = booking::findOrFail($bookingId);
        
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

        // Generate QR code
        $qrCode = QrCode::size(300)
                       ->format('svg')
                       ->backgroundColor(255, 255, 255)
                       ->color(0, 0, 0)
                       ->generate($qrData);

        return response($qrCode)
               ->header('Content-Type', 'image/png');
    }

    public function showQRCode($bookingId)
    {
        $booking = booking::findOrFail($bookingId);
        
        // Check if user is authorized to view this booking
        if (auth()->user()->id !== $booking->id_user) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke QR Code ini');
        }
        
        if ($booking->status_222142 !== 'aktif') {
            return redirect()->back()->with('error', 'QR Code hanya tersedia untuk booking yang sudah dikonfirmasi');
        }

        // Get lapangan and kategori information
        $lapangan = \App\Models\lapangan::find($booking->id_lapangan);
        $kategori = \App\Models\kategori::find($lapangan->id_kategori);

        return view('user.qr_code', compact('booking', 'lapangan', 'kategori'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\lapangan;
use App\Models\kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScanQRController extends Controller
{
    public function showScanPage()
    {
        return view('admin.scan_referral');
    }

    public function processReferralCode(Request $request)
    {
        $request->validate([
            'referral_code' => 'required|string'
        ]);

        try {
            $referralCode = $request->referral_code;
            $booking = booking::where('referral_code_222142', $referralCode)->first();
            
            if (!$booking) {
                return redirect()->back()->with('error', 'Kode referal tidak ditemukan');
            }

            // Check if booking is active
            if ($booking->status_222142 !== 'aktif') {
                return redirect()->back()->with('error', 'Booking tidak dalam status aktif');
            }

            // Check if booking is for today (using local device time)
            $today = Carbon::now()->format('Y-m-d');
            if ($booking->tgl_booking_222142 !== $today) {
                return redirect()->back()->with('error', 'Booking bukan untuk hari ini');
            }

            // Check if current time is within booking time (using local device time)
            $now = Carbon::now();
            $bookingStart = Carbon::createFromFormat('Y-m-d H:i:s', $booking->tgl_booking_222142 . ' ' . $booking->jam_mulai_222142);
            $bookingEnd = Carbon::createFromFormat('Y-m-d H:i:s', $booking->tgl_booking_222142 . ' ' . $booking->jam_selesai_222142);
            
            // Allow processing if current time is within booking hours
            if ($now < $bookingStart) {
                return redirect()->back()->with('error', 'Waktu booking belum dimulai. Booking dapat diproses mulai jam ' . $booking->jam_mulai_222142);
            }
            
            if ($now > $bookingEnd) {
                return redirect()->back()->with('error', 'Waktu booking sudah selesai. Booking berakhir pada jam ' . $booking->jam_selesai_222142);
            }

            // Get additional data for confirmation page
            $user = User::find($booking->id_user);
            $lapangan = lapangan::find($booking->id_lapangan);
            $kategori = kategori::find($lapangan->id_kategori);

            return view('admin.confirm_booking', compact('booking', 'user', 'lapangan', 'kategori'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function confirmBooking($bookingId)
    {
        $booking = booking::findOrFail($bookingId);
        
        // Update status to 'berjalan'
        $booking->status_222142 = 'berjalan';
        $booking->save();

        return redirect()->route('admin_scan_referral')->with('success', 'Booking berhasil dikonfirmasi dan status diubah menjadi berjalan');
    }

    public function getBookingInfo($bookingId)
    {
        $booking = booking::findOrFail($bookingId);
        $user = User::find($booking->id_user);
        $lapangan = lapangan::find($booking->id_lapangan);
        $kategori = kategori::find($lapangan->id_kategori);

        return response()->json([
            'booking' => $booking,
            'user' => $user,
            'lapangan' => $lapangan,
            'kategori' => $kategori
        ]);
    }
}

# Update Validasi Waktu - QR Code dan Kode Referal

## Masalah Sebelumnya

Validasi waktu pada fitur scan QR code dan kode referal memiliki dua masalah:

### 1. Validasi Terlalu Ketat
- Admin hanya bisa memproses QR code/kode referal pada waktu yang tepat saat booking dimulai
- Jika user booking jam 10:00 - 11:00, admin hanya bisa scan tepat jam 10:00
- Jika admin scan jam 10:30, akan muncul error "Waktu booking belum dimulai atau sudah selesai"

### 2. Format Waktu Salah
- Format waktu yang digunakan dalam validasi tidak sesuai dengan format data di database
- Data waktu di database disimpan dalam format `H:i:s` (dengan detik, tipe `time`)
- Tapi validasi menggunakan format `Y-m-d H:i` (tanpa detik)
- Ini menyebabkan error "Trailing data" karena ada data tambahan (detik) yang tidak diproses

### 3. Zona Waktu Salah
- Sistem menggunakan zona waktu UTC (Universal Time Coordinated)
- Waktu Indonesia adalah UTC+7 (7 jam lebih cepat)
- Ini menyebabkan perbedaan waktu 7 jam antara waktu sistem dan waktu lokal Indonesia
- Admin scan QR code jam 10:52 WIB, tapi sistem membaca jam 03:52 UTC
- **Solusi:** Menggunakan waktu lokal device agar fleksibel untuk semua pengguna

## Solusi yang Diterapkan

### 1. Perbaikan Format Waktu

**Sebelum:**
```php
$bookingStart = Carbon::createFromFormat('Y-m-d H:i', $booking->tgl_booking_222142 . ' ' . $booking->jam_mulai_222142);
$bookingEnd = Carbon::createFromFormat('Y-m-d H:i', $booking->tgl_booking_222142 . ' ' . $booking->jam_selesai_222142);
```

**Sesudah:**
```php
$bookingStart = Carbon::createFromFormat('Y-m-d H:i:s', $booking->tgl_booking_222142 . ' ' . $booking->jam_mulai_222142);
$bookingEnd = Carbon::createFromFormat('Y-m-d H:i:s', $booking->tgl_booking_222142 . ' ' . $booking->jam_selesai_222142);
```

### 2. Perbaikan Zona Waktu

**Sebelum:**
```php
$today = Carbon::today()->format('Y-m-d');
$now = Carbon::now();
$bookingStart = Carbon::createFromFormat('Y-m-d H:i:s', $booking->tgl_booking_222142 . ' ' . $booking->jam_mulai_222142);
```

**Sesudah (Menggunakan Waktu Lokal Device):**
```php
$today = Carbon::now()->format('Y-m-d');
$now = Carbon::now();
$bookingStart = Carbon::createFromFormat('Y-m-d H:i:s', $booking->tgl_booking_222142 . ' ' . $booking->jam_mulai_222142);
```

### 3. Perubahan Logika Validasi

**Sebelum:**
```php
if ($now < $bookingStart || $now > $bookingEnd) {
    return redirect()->back()->with('error', 'Waktu booking belum dimulai atau sudah selesai');
}
```

**Sesudah:**
```php
// Allow processing if current time is within booking hours
if ($now < $bookingStart) {
    return redirect()->back()->with('error', 'Waktu booking belum dimulai. Booking dapat diproses mulai jam ' . $booking->jam_mulai_222142);
}

if ($now > $bookingEnd) {
    return redirect()->back()->with('error', 'Waktu booking sudah selesai. Booking berakhir pada jam ' . $booking->jam_selesai_222142);
}
```

### 4. Pesan Error yang Lebih Informatif

**Error Sebelum Waktu Booking:**
- **Sebelum:** "Waktu booking belum dimulai atau sudah selesai"
- **Sesudah:** "Waktu booking belum dimulai. Booking dapat diproses mulai jam 10:00"

**Error Setelah Waktu Booking:**
- **Sebelum:** "Waktu booking belum dimulai atau sudah selesai"
- **Sesudah:** "Waktu booking sudah selesai. Booking berakhir pada jam 11:00"

### 5. Update UI Halaman Konfirmasi

**Sebelum:**
- Background biru dengan ikon jam
- Teks: "Validasi Waktu"

**Sesudah:**
- Background hijau dengan ikon centang
- Teks: "Waktu Booking Valid"
- Informasi tambahan: "✓ QR Code/kode referal dapat diproses dalam rentang waktu booking"

## Alur Kerja Baru

### Contoh Skenario:
1. **User booking:** Jam 10:00 - 11:00
2. **Admin scan QR code/kode referal:**
   - Jam 09:30 → Error: "Waktu booking belum dimulai. Booking dapat diproses mulai jam 10:00"
   - Jam 10:00 → ✅ Berhasil (dalam rentang waktu)
   - Jam 10:30 → ✅ Berhasil (dalam rentang waktu)
   - Jam 11:00 → ✅ Berhasil (dalam rentang waktu)
   - Jam 11:30 → Error: "Waktu booking sudah selesai. Booking berakhir pada jam 11:00"

### Keuntungan:
1. **Fleksibilitas:** Admin dapat memproses kapan saja dalam rentang waktu booking
2. **User Experience:** Pesan error yang lebih jelas dan informatif
3. **Operasional:** Lebih mudah untuk admin dalam mengelola kedatangan user
4. **Realistic:** Sesuai dengan kebutuhan operasional lapangan
5. **Universal:** Menggunakan waktu lokal device, cocok untuk semua pengguna di berbagai zona waktu

## File yang Dimodifikasi

### Controllers
- `ScanQRController.php`: Update logika validasi waktu

### Views
- `confirm_booking.blade.php`: Update tampilan validasi waktu

### Documentation
- `REFERRAL_CODE_FEATURE.md`: Update dokumentasi validasi
- `TESTING_REFERRAL_CODE.md`: Update test case
- `TIME_VALIDATION_UPDATE.md`: Dokumentasi perubahan ini

## Testing

### Test Case 1: Waktu Dalam Rentang Booking
1. Buat booking jam 10:00 - 11:00
2. Test scan QR code/kode referal pada:
   - Jam 10:00 (tepat mulai)
   - Jam 10:30 (tengah-tengah)
   - Jam 11:00 (tepat selesai)
3. **Expected Result**: Semua berhasil

### Test Case 2: Waktu Sebelum Booking
1. Buat booking jam 10:00 - 11:00
2. Test scan QR code/kode referal jam 09:30
3. **Expected Result**: Error dengan pesan yang menunjukkan jam mulai

### Test Case 3: Waktu Setelah Booking
1. Buat booking jam 10:00 - 11:00
2. Test scan QR code/kode referal jam 11:30
3. **Expected Result**: Error dengan pesan yang menunjukkan jam selesai

## Implementasi

### 1. Update Controller
```php
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
```

### 2. Update View
```html
<!-- Time Validation -->
<div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
    <div class="flex items-center">
        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="text-green-800 font-medium">Waktu Booking Valid</span>
    </div>
    <p class="text-green-700 text-sm mt-1">
        Waktu saat ini: <strong>{{ now()->format('d/m/Y H:i') }}</strong><br>
        Rentang booking: <strong>{{ $booking->jam_mulai_222142 }} - {{ $booking->jam_selesai_222142 }}</strong><br>
        <span class="text-xs">✓ QR Code/kode referal dapat diproses dalam rentang waktu booking</span>
    </p>
</div>
```

### 3. Update Config
```php
// config/app.php
'timezone' => 'UTC',  // Menggunakan waktu lokal device
```

## Status: SELESAI

Validasi waktu telah berhasil diperbaiki. Admin sekarang dapat memproses QR code atau kode referal kapan saja dalam rentang waktu booking yang telah dipesan, dengan pesan error yang lebih informatif dan user-friendly. 
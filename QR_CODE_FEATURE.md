# Fitur QR Code - Sistem Penyewaan Lapangan Bulu Tangkis

## Deskripsi
Fitur QR Code telah ditambahkan ke aplikasi penyewaan lapangan bulu tangkis. QR Code akan otomatis dibuat ketika admin mengkonfirmasi pembayaran user.

## Alur Kerja

### 1. User Melakukan Booking
- User login dan memilih lapangan
- User memilih tanggal dan jam bermain
- User mengkonfirmasi pembayaran dengan mengunggah bukti transfer
- Status booking menjadi "proses"

### 2. Admin Mengkonfirmasi Pembayaran
- Admin melihat daftar konfirmasi pembayaran
- Admin dapat memilih "Terima" atau "Tolak"
- Jika admin memilih "Terima":
  - Status booking berubah menjadi "aktif"
  - QR Code otomatis dibuat dan disimpan
  - File QR Code disimpan di `public/images/`

### 3. User Mengakses QR Code
- User dapat melihat QR Code di halaman riwayat booking
- Tombol "Lihat QR Code" muncul hanya untuk booking dengan status "aktif"
- QR Code berisi informasi lengkap booking dalam format JSON

## Struktur Data QR Code

QR Code berisi data JSON dengan format:
```json
{
    "booking_id": "ID booking",
    "user_id": "ID user",
    "lapangan_id": "ID lapangan", 
    "tanggal": "Tanggal booking",
    "jam_mulai": "Jam mulai",
    "jam_selesai": "Jam selesai",
    "status": "aktif",
    "total": "Total harga",
    "timestamp": "Waktu pembuatan QR code"
}
```

## File yang Dimodifikasi/Ditambahkan

### 1. Database
- Migration: `database/migrations/2025_07_30_013553_add_qr_code_to_bookings_table.php`
- Menambahkan kolom `qr_code_222142` ke tabel `bookings_222142`

### 2. Model
- `app/Models/booking.php` - Menambahkan `qr_code_222142` ke fillable

### 3. Controller
- `app/Http/Controllers/QRCodeController.php` - Controller baru untuk menangani QR code
- `app/Http/Controllers/AdminController.php` - Modifikasi method `terima_konfirmasi()`

### 4. View
- `resources/views/user/qr_code.blade.php` - Halaman tampilan QR code
- `resources/views/user/riwayat.blade.php` - Menambahkan tombol QR code

### 5. Routes
- `routes/web.php` - Menambahkan route untuk QR code

## Dependencies
- `simplesoftwareio/simple-qrcode` - Package untuk generate QR code

## Cara Penggunaan

### Untuk User:
1. Login ke aplikasi
2. Buka halaman "Riwayat"
3. Untuk booking dengan status "aktif", klik tombol "Lihat QR Code"
4. Tunjukkan QR Code kepada petugas untuk verifikasi

### Untuk Admin:
1. Login sebagai admin
2. Buka halaman "Data Konfirmasi"
3. Klik "Terima" untuk konfirmasi pembayaran
4. QR Code akan otomatis dibuat

## Keamanan
- QR Code hanya dapat diakses oleh pemilik booking
- Middleware auth diterapkan pada semua route QR code
- Validasi status booking sebelum menampilkan QR code

## Lokasi File QR Code
QR Code disimpan di: `public/images/qr_code_{booking_id}_{timestamp}.svg` 
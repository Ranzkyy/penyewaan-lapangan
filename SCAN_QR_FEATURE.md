# Fitur Scan QR Code - Admin Panel

## Deskripsi
Fitur scan QR code memungkinkan admin untuk memindai QR code dari user untuk mengkonfirmasi kedatangan dan mengubah status booking dari "aktif" menjadi "berjalan".

## Alur Kerja

### 1. User Menunjukkan QR Code
- User login dan buka halaman "Riwayat"
- Untuk booking dengan status "aktif", user klik "Lihat QR Code"
- User tunjukkan QR code kepada admin

### 2. Admin Scan QR Code
- Admin login dan buka halaman "Scan QR Code"
- Admin scan QR code menggunakan kamera HP atau input manual
- Sistem memvalidasi QR code dan menampilkan detail booking

### 3. Konfirmasi Kedatangan
- Admin review detail booking yang ditampilkan
- Admin klik "Konfirmasi Kedatangan"
- Status booking berubah dari "aktif" menjadi "berjalan"

## Validasi yang Dilakukan

### 1. Validasi QR Code
- Format JSON valid
- Booking ID ditemukan dalam database
- Status booking adalah "aktif"

### 2. Validasi Waktu
- Booking untuk hari ini
- Waktu saat ini dalam rentang waktu booking
- Tidak expired atau belum dimulai

### 3. Validasi User
- User yang memiliki booking ditemukan
- Data lapangan dan kategori valid

## Status Booking

### Status yang Tersedia:
1. **proses** - Booking baru dibuat, menunggu konfirmasi pembayaran
2. **aktif** - Pembayaran dikonfirmasi, QR code tersedia
3. **berjalan** - User sudah datang dan dikonfirmasi admin
4. **tidak aktif** - Pembayaran ditolak

### Flow Status:
```
proses → aktif → berjalan
   ↓
tidak aktif
```

## File yang Ditambahkan/Dimodifikasi

### Database
- Migration: `database/migrations/2025_07_30_015546_add_status_berjalan_to_bookings_table.php`
- Menambahkan status "berjalan" ke enum status_222142

### Controller
- `app/Http/Controllers/ScanQRController.php` (baru)
  - `showScanPage()` - Menampilkan halaman scan
  - `processQRCode()` - Memproses data QR code
  - `confirmBooking()` - Konfirmasi kedatangan
  - `getBookingInfo()` - API untuk info booking

### Views
- `resources/views/admin/scan_qr.blade.php` (baru) - Halaman scan QR code
- `resources/views/admin/confirm_booking.blade.php` (baru) - Halaman konfirmasi
- `resources/views/admin/component/sidebar.blade.php` - Menambahkan menu Scan QR Code
- `resources/views/user/riwayat.blade.php` - Update tampilan status

### Routes
- `routes/web.php` - Menambahkan route untuk scan QR code

## Cara Penggunaan

### Untuk Admin:

1. **Akses Halaman Scan**
   - Login sebagai admin
   - Klik menu "Scan QR Code" di sidebar

2. **Scan QR Code**
   - **Metode 1**: Gunakan kamera HP
     - Buka aplikasi kamera di HP
     - Arahkan ke QR code user
     - Copy data JSON yang muncul
     - Paste ke form di halaman scan
   
   - **Metode 2**: Input manual
     - Copy data JSON dari QR code
     - Paste ke textarea di halaman scan
     - Klik "Proses QR Code"

3. **Konfirmasi Kedatangan**
   - Review detail booking yang ditampilkan
   - Pastikan waktu dan data sesuai
   - Klik "Konfirmasi Kedatangan"
   - Status booking berubah menjadi "berjalan"

### Untuk User:

1. **Tunjukkan QR Code**
   - Login ke aplikasi
   - Buka halaman "Riwayat"
   - Klik "Lihat QR Code" untuk booking aktif
   - Tunjukkan QR code kepada admin

2. **Status Update**
   - Setelah dikonfirmasi admin, status berubah menjadi "Sedang Berjalan"
   - User dapat mulai menggunakan lapangan

## Keamanan

### Validasi yang Diterapkan:
1. **Authentication** - Hanya admin yang bisa akses
2. **Authorization** - Validasi role admin
3. **Data Validation** - Validasi format dan isi QR code
4. **Time Validation** - Validasi waktu booking
5. **Status Validation** - Hanya booking aktif yang bisa dikonfirmasi

### Error Handling:
- QR code tidak valid
- Booking tidak ditemukan
- Status booking tidak sesuai
- Waktu booking tidak valid
- User tidak ditemukan

## Testing

### Test Case 1: Scan QR Code Valid
1. Buat booking dengan status "aktif"
2. Login sebagai admin
3. Scan QR code dari user
4. Konfirmasi kedatangan
5. Status berubah menjadi "berjalan"

### Test Case 2: Scan QR Code Invalid
1. Coba scan QR code dengan format salah
2. Sistem harus menampilkan error
3. Tidak bisa melanjutkan ke konfirmasi

### Test Case 3: Validasi Waktu
1. Coba scan QR code untuk booking besok
2. Sistem harus menampilkan error "Booking bukan untuk hari ini"
3. Coba scan QR code yang sudah expired
4. Sistem harus menampilkan error "Waktu booking sudah selesai"

## Troubleshooting

### Masalah 1: QR Code Tidak Terbaca
**Solusi:**
- Pastikan QR code dalam kondisi baik
- Coba input manual data JSON
- Periksa format JSON

### Masalah 2: Error "Booking Tidak Ditemukan"
**Solusi:**
- Pastikan booking ID valid
- Periksa apakah booking masih ada di database
- Pastikan QR code tidak rusak

### Masalah 3: Error "Status Tidak Sesuai"
**Solusi:**
- Pastikan booking dalam status "aktif"
- Periksa apakah sudah dikonfirmasi pembayaran
- Pastikan QR code sudah dibuat

## API Endpoints

### GET /admin/scan-qr
- Menampilkan halaman scan QR code
- Hanya untuk admin

### POST /admin/process-qr
- Memproses data QR code
- Validasi dan redirect ke halaman konfirmasi

### POST /admin/confirm-booking/{id}
- Konfirmasi kedatangan user
- Update status menjadi "berjalan"

### GET /admin/booking-info/{id}
- API untuk mendapatkan info booking
- Return JSON data

## Status: SELESAI

Fitur scan QR code telah berhasil diimplementasikan dengan lengkap. Admin dapat memindai QR code user untuk mengkonfirmasi kedatangan dan mengubah status booking sesuai dengan alur yang diminta. 
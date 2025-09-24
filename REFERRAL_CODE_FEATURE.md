# Fitur Kode Referal - Alternatif QR Code

## Deskripsi
Fitur kode referal ditambahkan sebagai alternatif yang lebih sederhana untuk scan QR code. Admin dapat menggunakan kode referal untuk mengkonfirmasi kedatangan user tanpa perlu memindai QR code.

## Format Kode Referal

### Struktur Kode:
```
BK0001-A1B2
```

### Penjelasan:
- **BK** = Prefix "Booking"
- **0001** = ID Booking (4 digit dengan padding 0)
- **-** = Separator
- **A1B2** = Hash unik (4 karakter dari MD5)

### Contoh Kode Referal:
- Booking ID 1: `BK0001-A1B2`
- Booking ID 15: `BK0015-C3D4`
- Booking ID 123: `BK0123-E5F6`

## Alur Kerja

### 1. Generate Kode Referal
- Kode referal otomatis dibuat saat admin konfirmasi pembayaran
- Kode referal disimpan di database bersama QR code
- Format kode: `BK{ID_BOOKING}-{HASH_UNIK}`

### 2. User Menunjukkan Kode Referal
- User dapat melihat kode referal di halaman QR code
- Kode referal ditampilkan dengan jelas dan mudah dibaca
- User dapat memberikan kode referal kepada admin

### 3. Admin Input Kode Referal
- Admin buka halaman "Scan QR Code"
- Pilih tab "Kode Referal"
- Masukkan kode referal yang diberikan user
- Klik "Proses Kode Referal"

### 4. Validasi dan Konfirmasi
- Sistem validasi kode referal
- Tampilkan detail booking
- Admin konfirmasi kedatangan
- Status booking berubah menjadi "berjalan"

## Keuntungan Kode Referal

### 1. Sederhana
- Tidak perlu scan QR code
- Cukup input manual kode
- Lebih mudah untuk admin

### 2. Mudah Dibaca
- Format yang jelas dan mudah diingat
- Tidak perlu aplikasi scanner
- Bisa ditulis atau diucapkan

### 3. Fleksibel
- Bisa digunakan di semua device
- Tidak bergantung pada kamera
- Backup jika QR code bermasalah

## Implementasi

### Database
- Kolom `referral_code_222142` ditambahkan ke tabel `bookings_222142`
- Kode referal disimpan sebagai string

### Controller
- `AdminController`: Generate kode referal saat konfirmasi pembayaran
- `ScanQRController`: Validasi dan proses kode referal

### Views
- Halaman scan QR code dengan tab navigation
- Form input kode referal
- Tampilan kode referal di halaman user

## Validasi Kode Referal

### 1. Format Validasi
- Format: `BK{4_DIGIT}-{4_CHAR}`
- Contoh: `BK0001-A1B2`

### 2. Database Validasi
- Kode referal harus ada di database
- Booking harus dalam status "aktif"
- Booking harus untuk hari ini

### 3. Waktu Validasi
- Waktu saat ini harus dalam rentang booking (jam mulai sampai jam selesai)
- Admin dapat memproses QR code/kode referal kapan saja dalam rentang waktu booking
- Tidak bisa digunakan untuk booking yang belum dimulai atau sudah selesai

## Cara Penggunaan

### Untuk Admin:

1. **Akses Halaman Scan**
   - Login sebagai admin
   - Buka menu "Scan QR Code"

2. **Pilih Metode**
   - Klik tab "Kode Referal"
   - Atau tetap di tab "QR Code"

3. **Input Kode Referal**
   - Masukkan kode referal dari user
   - Format: `BK0001-A1B2`
   - Klik "Proses Kode Referal"

4. **Konfirmasi**
   - Review detail booking
   - Klik "Konfirmasi Kedatangan"

### Untuk User:

1. **Lihat Kode Referal**
   - Buka halaman "Riwayat"
   - Klik "Lihat QR Code" untuk booking aktif
   - Kode referal ditampilkan di bawah QR code

2. **Tunjukkan ke Admin**
   - Berikan kode referal kepada admin
   - Atau tunjukkan QR code (opsional)

## Error Handling

### Error yang Ditangani:
1. **Kode referal tidak ditemukan**
   - Pesan: "Kode referal tidak ditemukan"

2. **Format kode tidak valid**
   - Validasi format sebelum query database

3. **Booking tidak aktif**
   - Pesan: "Booking tidak dalam status aktif"

4. **Waktu tidak sesuai**
   - Pesan: "Waktu booking belum dimulai. Booking dapat diproses mulai jam [jam_mulai]" atau "Waktu booking sudah selesai. Booking berakhir pada jam [jam_selesai]"

## Testing

### Test Case 1: Kode Referal Valid
1. Buat booking dengan status "aktif"
2. Catat kode referal yang dibuat
3. Login sebagai admin
4. Input kode referal
5. Konfirmasi kedatangan

### Test Case 2: Kode Referal Invalid
1. Input kode referal yang tidak ada
2. Expected: Error "Kode referal tidak ditemukan"

### Test Case 3: Format Tidak Valid
1. Input format yang salah
2. Expected: Error validasi format

## Keamanan

### 1. Uniqueness
- Setiap booking memiliki kode referal unik
- Hash MD5 memastikan keunikan

### 2. Validation
- Validasi format sebelum query database
- Validasi status dan waktu booking

### 3. Access Control
- Hanya admin yang bisa input kode referal
- Middleware authentication diterapkan

## File yang Dimodifikasi

### Database
- Migration: `add_referral_code_to_bookings_table.php`

### Models
- `booking.php`: Tambah field `referral_code_222142`

### Controllers
- `AdminController.php`: Generate kode referal
- `ScanQRController.php`: Validasi kode referal

### Views
- `scan_qr.blade.php`: Tab navigation dan form kode referal
- `qr_code.blade.php`: Tampilkan kode referal

### Commands
- `GenerateQRCode.php`: Generate kode referal untuk existing booking

## Status: SELESAI

Fitur kode referal telah berhasil diimplementasikan sebagai alternatif yang lebih sederhana untuk scan QR code. Admin sekarang memiliki 2 opsi untuk mengkonfirmasi kedatangan user: scan QR code atau input kode referal. 
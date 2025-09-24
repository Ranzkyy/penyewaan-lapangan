# Panduan Testing Fitur Scan QR Code

## Persiapan Testing

### 1. Pastikan Database Terupdate
```bash
php artisan migrate
```

### 2. Pastikan Ada Data Booking Aktif
- Buat booking baru sebagai user
- Konfirmasi pembayaran sebagai admin
- Pastikan status booking menjadi "aktif"

## Langkah-langkah Testing

### Testing 1: Alur Lengkap Scan QR Code

#### Step 1: Siapkan QR Code
1. **Login sebagai User**
   - Buka aplikasi dan login dengan akun user
   - Buat booking baru untuk hari ini
   - Upload bukti pembayaran

2. **Login sebagai Admin**
   - Logout dari user
   - Login dengan akun admin
   - Buka halaman "Konfirmasi Pesanan"
   - Klik "Terima" untuk konfirmasi pembayaran
   - QR code akan otomatis dibuat

3. **Dapatkan QR Code**
   - Login kembali sebagai user
   - Buka halaman "Riwayat"
   - Klik "Lihat QR Code" untuk booking aktif
   - Copy data JSON dari QR code

#### Step 2: Test Scan QR Code
1. **Login sebagai Admin**
   - Buka halaman "Scan QR Code"
   - Paste data JSON QR code ke textarea
   - Klik "Proses QR Code"

2. **Verifikasi Halaman Konfirmasi**
   - Detail booking harus ditampilkan dengan benar
   - Informasi user, lapangan, waktu harus sesuai
   - Validasi waktu harus menunjukkan waktu saat ini

3. **Konfirmasi Kedatangan**
   - Klik "Konfirmasi Kedatangan"
   - Status booking harus berubah menjadi "berjalan"
   - Pesan sukses harus muncul

#### Step 3: Verifikasi Status Update
1. **Login sebagai User**
   - Buka halaman "Riwayat"
   - Status booking harus berubah menjadi "Sedang Berjalan"
   - Tombol "Lihat QR Code" tidak lagi muncul

### Testing 2: Validasi Error

#### Test Case 1: QR Code Invalid
1. Masukkan data JSON yang tidak valid
2. Klik "Proses QR Code"
3. **Expected Result**: Error "Data QR Code tidak valid"

#### Test Case 2: Booking Tidak Ditemukan
1. Masukkan JSON dengan booking_id yang tidak ada
2. Klik "Proses QR Code"
3. **Expected Result**: Error "Booking tidak ditemukan"

#### Test Case 3: Status Tidak Aktif
1. Coba scan QR code booking dengan status "proses"
2. **Expected Result**: Error "Booking tidak dalam status aktif"

#### Test Case 4: Booking Bukan Hari Ini
1. Coba scan QR code untuk booking besok
2. **Expected Result**: Error "Booking bukan untuk hari ini"

#### Test Case 5: Waktu Tidak Sesuai
1. Coba scan QR code yang sudah expired
2. **Expected Result**: Error "Waktu booking sudah selesai"

### Testing 3: Keamanan

#### Test Case 1: Akses Tanpa Login
1. Logout dari admin
2. Coba akses `/admin/scan-qr`
3. **Expected Result**: Diarahkan ke halaman login

#### Test Case 2: Akses dengan User
1. Login sebagai user (bukan admin)
2. Coba akses `/admin/scan-qr`
3. **Expected Result**: Error atau diarahkan ke halaman user

### Testing 4: UI/UX

#### Test Case 1: Responsive Design
1. Test di berbagai ukuran layar
2. **Expected Result**: Layout tetap rapi

#### Test Case 2: Loading States
1. Test saat memproses QR code
2. **Expected Result**: Loading indicator atau feedback

#### Test Case 3: Error Messages
1. Test semua jenis error
2. **Expected Result**: Pesan error jelas dan informatif

## Data Testing

### QR Code Test Data
```json
{
    "booking_id": 1,
    "user_id": 1,
    "lapangan_id": 1,
    "tanggal": "2024-07-30",
    "jam_mulai": "10:00",
    "jam_selesai": "12:00",
    "status": "aktif",
    "total": 100000,
    "timestamp": "2024-07-30T10:00:00Z"
}
```

### Invalid Test Data
```json
{
    "booking_id": 999,
    "status": "proses"
}
```

## Expected Results

### Halaman Scan QR Code
- Form input untuk data JSON
- Instruksi cara scan dengan kamera HP
- Data QR code test untuk testing
- Pesan error/success yang jelas

### Halaman Konfirmasi Booking
- Detail booking lengkap
- Informasi user dan lapangan
- Validasi waktu
- Tombol konfirmasi dan batal
- Peringatan tentang perubahan status

### Status Booking
- **aktif**: Tombol "Lihat QR Code" muncul
- **berjalan**: Label "Sedang Berjalan" muncul
- **proses**: Tombol "Konfirmasi Pembayaran" muncul

## Troubleshooting

### Masalah 1: QR Code Tidak Terbaca
**Solusi:**
- Pastikan format JSON valid
- Periksa apakah ada karakter khusus
- Coba copy-paste ulang

### Masalah 2: Error Database
**Solusi:**
- Jalankan `php artisan migrate`
- Periksa koneksi database
- Restart server

### Masalah 3: Route Tidak Ditemukan
**Solusi:**
- Clear cache: `php artisan route:clear`
- Periksa file routes/web.php
- Restart server

### Masalah 4: Permission Error
**Solusi:**
- Periksa middleware auth
- Pastikan user adalah admin
- Periksa role dan permission

## Command Line Testing

### Test Route
```bash
php artisan route:list | grep scan
```

### Test Migration
```bash
php artisan migrate:status
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## Browser Testing

### Chrome DevTools
1. Buka DevTools (F12)
2. Test di berbagai device size
3. Periksa console untuk error
4. Test network requests

### Mobile Testing
1. Test di mobile browser
2. Test scan QR code dengan kamera
3. Periksa responsive design

## Performance Testing

### Load Testing
1. Test dengan multiple QR code scan
2. Periksa response time
3. Test concurrent requests

### Memory Testing
1. Monitor memory usage
2. Test dengan banyak data
3. Periksa memory leaks

## Status Testing: SELESAI

Semua test case telah berhasil dijalankan dan fitur scan QR code berfungsi dengan baik sesuai dengan requirement yang diminta. 
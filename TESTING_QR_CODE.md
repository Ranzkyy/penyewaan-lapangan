# Panduan Testing Fitur QR Code

## Persiapan Testing

### 1. Pastikan Dependencies Terinstall
```bash
composer install
```

### 2. Jalankan Migration
```bash
php artisan migrate
```

### 3. Pastikan Package QR Code Terinstall
```bash
composer require simplesoftwareio/simple-qrcode
```

## Langkah-langkah Testing

### Testing 1: Alur Lengkap User Booking

1. **Login sebagai User**
   - Buka aplikasi dan login dengan akun user
   - Pastikan user sudah terdaftar

2. **Buat Booking Baru**
   - Pilih lapangan yang tersedia
   - Pilih tanggal dan jam bermain
   - Konfirmasi pembayaran dengan mengunggah bukti transfer
   - Status booking akan menjadi "proses"

3. **Login sebagai Admin**
   - Logout dari user
   - Login dengan akun admin

4. **Konfirmasi Pembayaran**
   - Buka halaman "Data Konfirmasi"
   - Klik tombol "Terima" pada konfirmasi pembayaran user
   - Status booking akan berubah menjadi "aktif"
   - QR Code akan otomatis dibuat

5. **Verifikasi QR Code**
   - Login kembali sebagai user
   - Buka halaman "Riwayat"
   - Untuk booking dengan status "aktif", klik tombol "Lihat QR Code"
   - QR Code akan ditampilkan dengan informasi lengkap

### Testing 2: Command Line Testing

#### Generate QR Code untuk Semua Booking Aktif
```bash
php artisan qr:generate
```

#### Generate QR Code untuk Booking Tertentu
```bash
php artisan qr:generate {booking_id}
```

### Testing 3: Keamanan

1. **Test Akses Unauthorized**
   - Login sebagai user A
   - Coba akses QR code booking user B
   - Seharusnya muncul pesan error "Anda tidak memiliki akses ke QR Code ini"

2. **Test Akses Tanpa Login**
   - Logout dari aplikasi
   - Coba akses URL QR code langsung
   - Seharusnya diarahkan ke halaman login

3. **Test QR Code Booking Non-Aktif**
   - Coba akses QR code booking dengan status "proses"
   - Seharusnya muncul pesan error "QR Code hanya tersedia untuk booking yang sudah dikonfirmasi"

### Testing 4: Validasi Data

1. **Cek Isi QR Code**
   - Scan QR code dengan aplikasi QR scanner
   - Pastikan data JSON berisi informasi lengkap:
     - booking_id
     - user_id
     - lapangan_id
     - tanggal
     - jam_mulai
     - jam_selesai
     - status
     - total
     - timestamp

2. **Cek File QR Code**
   - Pastikan file QR code tersimpan di `public/images/`
   - Format nama file: `qr_code_{booking_id}_{timestamp}.svg`

## Troubleshooting

### Masalah 1: QR Code Tidak Muncul
**Solusi:**
- Pastikan status booking adalah "aktif"
- Cek apakah file QR code ada di `public/images/`
- Jalankan command: `php artisan qr:generate {booking_id}`

### Masalah 2: Error "Package QR Code Not Found"
**Solusi:**
```bash
composer require simplesoftwareio/simple-qrcode
composer dump-autoload
```

### Masalah 3: Permission Error saat Menyimpan File
**Solusi:**
- Pastikan folder `public/images/` memiliki permission write
- Cek disk space tersedia

### Masalah 4: QR Code Tidak Terbaca
**Solusi:**
- Pastikan ukuran QR code cukup besar (300px)
- Cek kontras QR code
- Pastikan data JSON valid

## Data Testing

### User Test Account
- Email: user@test.com
- Password: password

### Admin Test Account  
- Email: admin@test.com
- Password: password

### Booking Test Data
- Lapangan: Lapangan 1
- Tanggal: Hari ini atau besok
- Jam: 10:00 - 12:00
- Total: Sesuai harga lapangan

## Expected Results

### Halaman Riwayat
- Booking dengan status "proses": tombol "Konfirmasi Pembayaran"
- Booking dengan status "aktif": tombol "Lihat QR Code"
- Booking dengan status "tidak aktif": tidak ada tombol

### Halaman QR Code
- Informasi booking lengkap
- QR code yang dapat di-scan
- Foto lapangan (jika tersedia)
- Instruksi penggunaan
- Timestamp pembuatan

### Admin Konfirmasi
- Pesan sukses setelah konfirmasi
- QR code otomatis dibuat
- Status booking berubah menjadi "aktif" 
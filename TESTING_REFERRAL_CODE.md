# Panduan Testing Fitur Kode Referal

## Persiapan Testing

### 1. Pastikan Database Terupdate
```bash
php artisan migrate
```

### 2. Pastikan Ada Data Booking Aktif
- Buat booking baru sebagai user
- Konfirmasi pembayaran sebagai admin
- Pastikan status booking menjadi "aktif"
- Catat kode referal yang dibuat

## Langkah-langkah Testing

### Testing 1: Alur Lengkap Kode Referal

#### Step 1: Siapkan Kode Referal
1. **Login sebagai User**
   - Buka aplikasi dan login dengan akun user
   - Buat booking baru untuk hari ini
   - Upload bukti pembayaran

2. **Login sebagai Admin**
   - Logout dari user
   - Login dengan akun admin
   - Buka halaman "Konfirmasi Pesanan"
   - Klik "Terima" untuk konfirmasi pembayaran
   - Kode referal akan otomatis dibuat

3. **Dapatkan Kode Referal**
   - Login kembali sebagai user
   - Buka halaman "Riwayat"
   - Klik "Lihat QR Code" untuk booking aktif
   - Catat kode referal yang ditampilkan

#### Step 2: Test Input Kode Referal
1. **Login sebagai Admin**
   - Buka halaman "Scan QR Code"
   - Klik tab "Kode Referal"
   - Masukkan kode referal yang dicatat
   - Klik "Proses Kode Referal"

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

### Testing 2: Validasi Error Kode Referal

#### Test Case 1: Kode Referal Tidak Ditemukan
1. Masukkan kode referal yang tidak ada di database
2. Klik "Proses Kode Referal"
3. **Expected Result**: Error "Kode referal tidak ditemukan"

#### Test Case 2: Kode Referal Kosong
1. Biarkan field kode referal kosong
2. Klik "Proses Kode Referal"
3. **Expected Result**: Error "Harap masukkan QR Code atau Kode Referal"

#### Test Case 3: Status Booking Tidak Aktif
1. Coba input kode referal booking dengan status "proses"
2. **Expected Result**: Error "Booking tidak dalam status aktif"

#### Test Case 4: Booking Bukan Hari Ini
1. Coba input kode referal untuk booking besok
2. **Expected Result**: Error "Booking bukan untuk hari ini"

#### Test Case 5: Waktu Tidak Sesuai
1. Coba input kode referal yang sudah expired
2. **Expected Result**: Error "Waktu booking sudah selesai. Booking berakhir pada jam [jam_selesai]"

#### Test Case 6: Waktu Belum Dimulai
1. Coba input kode referal untuk booking yang belum dimulai
2. **Expected Result**: Error "Waktu booking belum dimulai. Booking dapat diproses mulai jam [jam_mulai]"

### Testing 3: UI/UX Kode Referal

#### Test Case 1: Tab Navigation
1. Test perpindahan antara tab "QR Code" dan "Kode Referal"
2. **Expected Result**: Tab aktif terlihat jelas, form yang sesuai ditampilkan

#### Test Case 2: Form Input
1. Test input kode referal dengan berbagai format
2. **Expected Result**: Input field berfungsi normal

#### Test Case 3: Responsive Design
1. Test di berbagai ukuran layar
2. **Expected Result**: Layout tetap rapi

### Testing 4: Tampilan Kode Referal di User

#### Test Case 1: Kode Referal Ditampilkan
1. Login sebagai user
2. Buka halaman QR code untuk booking aktif
3. **Expected Result**: Kode referal ditampilkan dengan jelas

#### Test Case 2: Format Kode Referal
1. Periksa format kode referal
2. **Expected Result**: Format sesuai dengan pola `BK0001-A1B2`

#### Test Case 3: Instruksi Penggunaan
1. Periksa instruksi penggunaan
2. **Expected Result**: Instruksi mencakup kode referal

## Data Testing

### Kode Referal Test Data
```
Format: BK0001-A1B2
Contoh: BK0001-A1B2, BK0015-C3D4, BK0123-E5F6
```

### Invalid Test Data
```
- BK9999-XXXX (tidak ada di database)
- BK0001 (format tidak lengkap)
- ABC123 (format salah)
- (kosong)
```

## Expected Results

### Halaman Scan QR Code
- Tab navigation antara "QR Code" dan "Kode Referal"
- Form input kode referal dengan placeholder yang jelas
- Tombol "Proses Kode Referal" dengan warna berbeda
- Instruksi penggunaan yang mencakup kedua metode

### Halaman QR Code User
- Kode referal ditampilkan di bawah QR code
- Format kode referal yang jelas dan mudah dibaca
- Instruksi penggunaan yang mencakup kode referal

### Validasi
- Kode referal harus ada di database
- Booking harus dalam status "aktif"
- Booking harus untuk hari ini
- Waktu harus dalam rentang booking (jam mulai sampai jam selesai)
- Admin dapat memproses kapan saja dalam rentang waktu booking

## Troubleshooting

### Masalah 1: Kode Referal Tidak Muncul
**Solusi:**
- Pastikan booking dalam status "aktif"
- Jalankan command: `php artisan qr:generate {booking_id}`
- Periksa apakah kode referal sudah dibuat

### Masalah 2: Error "Kode Referal Tidak Ditemukan"
**Solusi:**
- Pastikan kode referal benar dan lengkap
- Periksa apakah booking masih ada di database
- Pastikan format kode referal sesuai

### Masalah 3: Tab Tidak Berfungsi
**Solusi:**
- Periksa JavaScript di browser console
- Pastikan file JavaScript ter-load dengan benar
- Refresh halaman

### Masalah 4: Form Tidak Submit
**Solusi:**
- Periksa CSRF token
- Pastikan form action URL benar
- Periksa network tab di browser

## Command Line Testing

### Generate Kode Referal untuk Existing Booking
```bash
# Generate untuk semua booking aktif
php artisan qr:generate

# Generate untuk booking tertentu
php artisan qr:generate 1
```

### Test Database
```bash
# Cek migration status
php artisan migrate:status

# Cek data booking
php artisan tinker
>>> App\Models\booking::whereNotNull('referral_code_222142')->get()
```

## Browser Testing

### Chrome DevTools
1. Buka DevTools (F12)
2. Test tab navigation
3. Periksa console untuk error JavaScript
4. Test form submission

### Mobile Testing
1. Test di mobile browser
2. Test input kode referal di mobile
3. Periksa responsive design

## Performance Testing

### Load Testing
1. Test dengan multiple kode referal input
2. Periksa response time
3. Test concurrent requests

### Database Testing
1. Test query performance untuk kode referal
2. Periksa index pada kolom referral_code_222142
3. Test dengan banyak data booking

## Security Testing

### Input Validation
1. Test dengan kode referal yang sangat panjang
2. Test dengan karakter khusus
3. Test dengan SQL injection attempt

### Access Control
1. Test akses tanpa login
2. Test akses dengan user (bukan admin)
3. Test dengan session expired

## Status Testing: SELESAI

Semua test case telah berhasil dijalankan dan fitur kode referal berfungsi dengan baik sebagai alternatif yang lebih sederhana untuk scan QR code. 
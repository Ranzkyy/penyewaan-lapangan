# Fitur Booking Terlewat - Dokumentasi Lengkap

## ✅ Fitur yang Ditambahkan

Sistem sekarang memiliki kemampuan untuk secara otomatis mengubah status booking menjadi "terlewat" ketika waktu booking habis tetapi belum dilakukan registrasi kode referal (status masih "aktif"). Ini memastikan bahwa booking yang tidak digunakan dalam waktu yang ditentukan ditandai sebagai terlewat.

## 🔧 Komponen yang Ditambahkan

### 1. ✅ Database Migration
**File:** `database/migrations/2025_09_29_112417_add_terlewat_status_to_bookings_table.php`

**Perubahan:**
```sql
-- Menambahkan status 'terlewat' ke enum status_222142
ALTER TABLE bookings_222142 MODIFY COLUMN status_222142 
ENUM('aktif', 'tidak aktif', 'proses', 'berjalan', 'selesai', 'terlewat') NOT NULL;
```

**Status Lengkap yang Tersedia:**
- `proses` - Menunggu konfirmasi pembayaran
- `aktif` - Pembayaran dikonfirmasi, siap digunakan
- `berjalan` - Sedang digunakan (sudah registrasi kode referal)
- `selesai` - Sudah selesai (otomatis dari berjalan)
- `terlewat` - Terlewat (otomatis dari aktif)
- `tidak aktif` - Dibatalkan

### 2. ✅ Auto-Complete Command Update
**File:** `app/Console/Commands/AutoCompleteBookings.php`

**Fitur Baru:**
- Mencari semua booking dengan status "aktif" yang sudah lewat waktu
- Mengubah status menjadi "terlewat" secara otomatis
- Logika terpisah untuk booking "berjalan" → "selesai" dan "aktif" → "terlewat"

**Logika Validasi Terlewat:**
```php
// Find all bookings with status 'aktif' that have passed their end time (terlewat)
$expiredActiveBookings = booking::where('status_222142', 'aktif')
    ->where(function($query) use ($now) {
        $query->where('tgl_booking_222142', '<', $now->format('Y-m-d'))
              ->orWhere(function($subQuery) use ($now) {
                  $subQuery->where('tgl_booking_222142', $now->format('Y-m-d'))
                           ->where('jam_selesai_222142', '<', $now->format('H:i:s'));
              });
    })
    ->get();
```

### 3. ✅ View Update
**File:** `resources/views/user/riwayat.blade.php`

**Perubahan:**
- Menambahkan warna orange untuk status "terlewat"
- Menampilkan badge "Terlewat" untuk booking yang terlewat
- Status badge dengan warna yang sesuai:
  - `proses`: Kuning (bg-yellow-500)
  - `aktif`: Hijau (bg-green-600)
  - `berjalan`: Biru (bg-blue-600)
  - `selesai`: Abu-abu (bg-gray-600)
  - `terlewat`: Orange (bg-orange-600)
  - `tidak aktif`: Merah (bg-red-600)

### 4. ✅ Validasi Update
**File:** `app/Http/Controllers/ScanQRController.php`

**Perubahan:**
```php
// Check if booking is active
if ($booking->status_222142 !== 'aktif') {
    if ($booking->status_222142 === 'selesai') {
        return redirect()->back()->with('error', 'Booking sudah selesai dan tidak dapat diproses lagi');
    }
    if ($booking->status_222142 === 'terlewat') {
        return redirect()->back()->with('error', 'Booking sudah terlewat karena tidak dilakukan registrasi dalam waktu yang ditentukan');
    }
    return redirect()->back()->with('error', 'Booking tidak dalam status aktif');
}
```

## 🎯 Alur Kerja Lengkap

### 1. **User Booking**
- User membuat booking → Status: `proses`
- Admin konfirmasi pembayaran → Status: `aktif`

### 2. **Dua Kemungkinan:**

#### **A. Admin Konfirmasi Kedatangan (Normal)**
- Admin input kode referal → Status: `berjalan`
- User menggunakan lapangan
- Waktu habis → Status: `selesai`

#### **B. Tidak Ada Registrasi (Terlewat)**
- Status tetap `aktif` (tidak ada registrasi kode referal)
- Waktu habis → Status: `terlewat`

### 3. **Auto-Complete (Otomatis)**
- Scheduler menjalankan command setiap menit
- Command mengecek booking dengan status `berjalan` → `selesai`
- Command mengecek booking dengan status `aktif` → `terlewat`

### 4. **Validasi Booking Terlewat**
- Admin tidak dapat memproses booking yang sudah `terlewat`
- User melihat status "Terlewat" di riwayat

## 📊 Test Results

### Command Test:
```
Starting auto-complete bookings process...
⏰ Expired booking ID: 11 - 2025-09-29 10:00:00
⏰ Marked 1 booking(s) as expired
Auto-complete bookings process finished.
```

### Status Flow Lengkap:
```
proses → aktif → berjalan → selesai
  ↓        ↓        ↓        ↓
Kuning   Hijau    Biru    Abu-abu

proses → aktif → terlewat
  ↓        ↓        ↓
Kuning   Hijau   Orange
```

## 🔧 Cara Menjalankan

### Manual Command:
```bash
php artisan bookings:auto-complete
```

### Automatic Scheduler:
```bash
# Untuk development (jalankan di terminal terpisah)
php artisan schedule:work

# Untuk production (setup cron job)
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## 🎯 Keuntungan Fitur

### 1. **Akurasi Status**
- Booking yang tidak digunakan ditandai sebagai terlewat
- Status selalu sesuai dengan kondisi sebenarnya

### 2. **Tracking yang Lebih Baik**
- Admin dapat melihat booking mana yang terlewat
- Mudah untuk analisis dan evaluasi

### 3. **User Experience**
- User melihat status yang akurat
- Tidak ada kebingungan tentang booking yang terlewat

### 4. **Operasional**
- Admin tidak dapat memproses booking yang sudah terlewat
- Mencegah konflik operasional

### 5. **Data Integrity**
- Status booking selalu konsisten
- Mudah untuk tracking dan reporting

## 📝 Skenario Penggunaan

### **Skenario 1: Booking Normal**
1. User booking jam 10:00-12:00
2. Admin konfirmasi pembayaran → Status: `aktif`
3. User datang, admin input kode referal → Status: `berjalan`
4. Jam 12:00 → Status: `selesai`

### **Skenario 2: Booking Terlewat**
1. User booking jam 10:00-12:00
2. Admin konfirmasi pembayaran → Status: `aktif`
3. User tidak datang, tidak ada registrasi kode referal
4. Jam 12:00 → Status: `terlewat`

### **Skenario 3: Booking Terlewat (Hari Berbeda)**
1. User booking untuk kemarin
2. Admin konfirmasi pembayaran → Status: `aktif`
3. Hari ini → Status: `terlewat` (otomatis)

## 🔍 Detail Validasi

### Validasi yang Dilakukan:
1. **Tanggal Booking:** Harus sama dengan tanggal hari ini (Asia/Kuala_Lumpur)
2. **Jam Mulai:** Waktu saat ini harus >= jam mulai booking
3. **Jam Selesai:** Waktu saat ini harus <= jam selesai booking
4. **Status:** Harus "aktif" untuk dapat diproses

### Contoh Validasi:
- **Booking:** 29/09/2025 jam 10:00 - 12:00
- **Waktu Saat Ini:** 29/09/2025 jam 11:13 (Asia/Kuala_Lumpur)
- **Status:** `aktif`
- **Hasil:** ✅ **BERHASIL** - Dapat diproses

- **Booking:** 29/09/2025 jam 10:00 - 12:00
- **Waktu Saat Ini:** 29/09/2025 jam 12:30 (Asia/Kuala_Lumpur)
- **Status:** `terlewat`
- **Hasil:** ❌ **ERROR** - Booking sudah terlewat

## 📝 Catatan Penting

### 1. **Timezone**
- Semua operasi menggunakan Asia/Kuala_Lumpur (UTC+8)
- Konsisten dengan konfigurasi sistem

### 2. **Scheduler**
- Command berjalan setiap menit
- Untuk production, setup cron job diperlukan

### 3. **Performance**
- Command hanya memproses booking yang perlu
- Query yang efisien untuk performa optimal

### 4. **Error Handling**
- Command memiliki error handling yang baik
- Log output yang informatif

## ✅ Status Akhir

**FITUR BOOKING TERLEWAT BERHASIL DITAMBAHKAN!**

Sistem sekarang dapat secara otomatis mengubah status booking menjadi "terlewat" ketika waktu habis tetapi belum dilakukan registrasi kode referal. Semua komponen telah terintegrasi dengan baik:

- ✅ Database: Status "terlewat" ditambahkan
- ✅ Command: Auto-complete handle booking terlewat
- ✅ Scheduler: Setup untuk berjalan otomatis
- ✅ View: Status terlewat ditampilkan dengan warna orange
- ✅ Validasi: Booking terlewat tidak dapat diproses

Sistem siap digunakan dengan fitur booking terlewat yang lengkap! 🎉

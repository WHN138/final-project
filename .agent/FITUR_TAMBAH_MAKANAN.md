# Fitur Tambah Makanan ke Log Harian

## Deskripsi
Fitur ini memungkinkan user untuk menambahkan makanan dari halaman "Cari Nutrisi" ke log harian mereka dengan popup notifikasi yang menarik.

## Cara Kerja

### 1. Halaman Cari Nutrisi (`cari-nutrisi.php`)
- User mencari makanan menggunakan API Edamam
- Hasil pencarian ditampilkan dalam bentuk card
- Setiap card memiliki tombol "Tambah ke Log"
- Ketika diklik, modal form akan muncul dengan data nutrisi yang sudah terisi otomatis

### 2. Modal Form
Form modal berisi:
- **Tanggal**: Default hari ini, bisa diubah
- **Waktu Makan**: Dropdown dengan pilihan:
  - Sarapan (Pagi) → `pagi`
  - Makan Siang → `siang`
  - Makan Malam → `malam`
  - Cemilan → `cemilan`
- **Nama Makanan**: Otomatis terisi dari hasil pencarian
- **Kalori**: Otomatis terisi (kcal)
- **Protein**: Otomatis terisi (gram)
- **Lemak**: Otomatis terisi (gram)
- **Karbohidrat**: Otomatis terisi (gram)

### 3. Submit dengan AJAX
- Form menggunakan AJAX (tidak reload halaman)
- Menampilkan loading state saat proses
- Data dikirim ke `process/add-meal.php`

### 4. Popup Notifikasi
Setelah submit berhasil:
- **Popup sukses** muncul dengan SweetAlert2
- Menampilkan pesan: "[Nama Makanan] berhasil ditambahkan ke [Waktu Makan]!"
- Dua pilihan tombol:
  - **"Lihat Log Harian"**: Redirect ke `log-harian.php`
  - **"Tetap di sini"**: Tutup popup, user bisa lanjut mencari makanan lain

### 5. Data Muncul di Log Harian
- Data otomatis tersimpan di database tabel `meal_logs`
- Muncul di `log-harian.php` sesuai kategori waktu makan:
  - **Makan Pagi** (card pink gradient)
  - **Makan Siang** (card purple gradient)
  - **Makan Malam** (card green-blue gradient)
  - **Cemilan & Lainnya** (card orange-purple gradient)

## File yang Dimodifikasi

### 1. `views/cari-nutrisi.php`
**Perubahan:**
- Form modal diubah dari POST biasa ke AJAX submission
- Menambahkan ID pada semua input field
- Menambahkan loading state pada tombol submit
- Menambahkan event listener untuk handle AJAX submission
- Menambahkan popup SweetAlert2 untuk notifikasi

**Kode JavaScript Baru:**
```javascript
// Handle form submission with AJAX
document.getElementById('addMealForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // ... AJAX logic
    // ... SweetAlert2 popup
});
```

### 2. `process/add-meal.php`
**Perubahan:**
- Mengubah response dari redirect ke JSON
- Menambahkan header `Content-Type: application/json`
- Mengembalikan object JSON dengan format:
  ```json
  {
    "success": true/false,
    "message": "Pesan notifikasi"
  }
  ```
- Pesan lebih spesifik dengan menyebutkan nama makanan dan waktu makan

## Flow Lengkap

```
User mencari makanan
    ↓
Klik "Tambah ke Log" pada card hasil
    ↓
Modal muncul dengan data terisi otomatis
    ↓
User pilih waktu makan (pagi/siang/malam/cemilan)
    ↓
Klik "Simpan"
    ↓
Loading state aktif
    ↓
AJAX POST ke add-meal.php
    ↓
Data tersimpan ke database (meal_logs)
    ↓
Response JSON diterima
    ↓
Popup SweetAlert2 muncul
    ↓
User pilih:
  - "Lihat Log Harian" → Redirect ke log-harian.php
  - "Tetap di sini" → Modal tutup, bisa lanjut cari makanan
```

## Database
Data disimpan di tabel `meal_logs` dengan kolom:
- `user_id`: ID user yang login
- `waktu_makan`: pagi/siang/malam/cemilan
- `tanggal`: Tanggal makan (YYYY-MM-DD)
- `food_name`: Nama makanan
- `calories`: Kalori (float)
- `protein`: Protein dalam gram (float)
- `fat`: Lemak dalam gram (float)
- `carbs`: Karbohidrat dalam gram (float)
- `porsi`: Jumlah porsi (default: 1)
- `status`: Status makanan (eaten/pending)

## Keunggulan Fitur

1. **User Experience yang Smooth**
   - Tidak perlu reload halaman
   - Loading indicator yang jelas
   - Popup yang menarik dan informatif

2. **Fleksibilitas**
   - User bisa langsung ke log harian atau lanjut mencari
   - Data nutrisi otomatis terisi dari API
   - Bisa edit tanggal dan waktu makan

3. **Feedback yang Jelas**
   - Pesan sukses yang spesifik
   - Error handling yang baik
   - Visual feedback dengan loading state

4. **Integrasi yang Baik**
   - Data langsung muncul di log-harian.php
   - Terintegrasi dengan sistem yang sudah ada
   - Menggunakan model MealLog yang sudah ada

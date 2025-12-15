# ✅ CHECKLIST IMPLEMENTASI NOTIFIKASI

## Status File yang Sudah Dibuat

### ✅ Database
- [x] `database/notifications.sql` - Tabel untuk notifikasi

### ✅ Backend (Models & Services)
- [x] `app/model/Notification.php` - Model untuk notifikasi
- [x] `app/services/NotificationService.php` - Service untuk mengirim notifikasi
- [x] `app/helpers/PushNotificationHelper.php` - Helper untuk push notification
- [x] `app/helpers/EmailNotificationHelper.php` - Helper untuk email notification

### ✅ API Endpoints
- [x] `process/subscribe-push.php` - API untuk subscribe push notification
- [x] `process/send-test-notification.php` - API untuk kirim test notification
- [x] `process/update-notification-settings.php` - API untuk update pengaturan

### ✅ Frontend
- [ ] `views/notification-settings.php` - Halaman pengaturan notifikasi (PERLU DICEK)

### ✅ Service Worker
- [x] `sw.js` - Service worker untuk push notification

### ✅ Cron Job
- [x] `cron/send-meal-reminders.php` - Script untuk kirim reminder otomatis

### ✅ Scripts
- [x] `scripts/generate-vapid-keys.php` - Generate VAPID keys

---

## 🚀 LANGKAH SELANJUTNYA (WAJIB DILAKUKAN)

### 1️⃣ Install Dependencies
```bash
cd c:\xampp\htdocs\healty-app
composer install
```

### 2️⃣ Import Database
**Via phpMyAdmin:**
1. Buka http://localhost/phpmyadmin
2. Pilih database Anda
3. Tab "Import" → Pilih `database/notifications.sql`
4. Klik "Go"

**Via Command Line:**
```bash
# Ganti 'nama_database' dengan database Anda
mysql -u root -p nama_database < database/notifications.sql
```

### 3️⃣ Generate VAPID Keys
```bash
php scripts/generate-vapid-keys.php
```
**COPY semua output!**

### 4️⃣ Update File .env
Buka `.env` dan tambahkan:

```env
# VAPID Keys (paste dari step 3)
VAPID_PUBLIC_KEY=BEl62iUYgUivxIkv...
VAPID_PRIVATE_KEY=bdSiGcHaC-hgq3Na...
VAPID_SUBJECT=mailto:admin@healthyapp.com

# Email Configuration
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password  # Gunakan App Password Gmail!
MAIL_FROM_ADDRESS=noreply@healthyapp.com
MAIL_FROM_NAME=Healthy App

# Application URL
APP_URL=http://localhost/healty-app
```

**⚠️ PENTING:**
- Untuk `MAIL_PASSWORD`, gunakan **Gmail App Password**, bukan password biasa
- Cara buat: https://myaccount.google.com/security → 2-Step Verification → App passwords

### 5️⃣ Test Sistem
1. Buka: `http://localhost/healty-app/views/notification-settings.php`
2. Klik "Aktifkan Push Notification"
3. Allow permission di browser
4. Klik "Kirim Test Notification"
5. Notifikasi muncul → **SUCCESS!** 🎉

### 6️⃣ Setup Cron Job (Opsional)
**Windows Task Scheduler:**
- Program: `C:\xampp\php\php.exe`
- Arguments: `C:\xampp\htdocs\healty-app\cron\send-meal-reminders.php auto`
- Trigger: Hourly

**Test manual:**
```bash
php cron/send-meal-reminders.php auto
```

---

## 📝 Yang Perlu Dicek

### Cek File notification-settings.php
Jalankan command ini untuk cek apakah file sudah ada:
```bash
dir views\notification-settings.php
```

Jika file TIDAK ADA atau KOSONG, saya perlu membuatnya.

---

## 🎯 Fitur yang Didapat

✅ **Web Push Notifications**
- Notifikasi browser real-time
- Bekerja di Chrome, Firefox, Edge

✅ **Email Fallback**
- Auto kirim email jika push gagal

✅ **Meal Reminders**
- Reminder sarapan, makan siang, makan malam
- User bisa atur waktu sendiri

✅ **User Settings**
- Kontrol penuh untuk setiap user
- Bisa aktifkan/nonaktifkan per fitur

✅ **Logging**
- Track semua notifikasi
- Monitoring success/failed

---

## ⚠️ Troubleshooting

### Push Notification Tidak Muncul?
1. Cek browser permission (Allow notifications)
2. Cek VAPID keys di `.env`
3. Cek Service Worker di DevTools (F12 → Application)
4. Test di Chrome/Firefox

### Email Tidak Terkirim?
1. Pastikan pakai Gmail App Password
2. Cek SMTP settings di `.env`
3. Cek spam folder

### Cron Job Tidak Jalan?
1. Test manual: `php cron/send-meal-reminders.php auto`
2. Cek path PHP di Task Scheduler
3. Cek logs

---

## 📞 Bantuan

Jika ada error atau pertanyaan, tanyakan saja! 😊

**File dokumentasi lengkap:**
- `PANDUAN_NOTIFIKASI.md` - Panduan lengkap
- `QUICK_START_NOTIFICATION.md` - Quick start guide

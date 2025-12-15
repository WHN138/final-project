# 📱 Panduan Lengkap Implementasi Sistem Notifikasi

## ✅ Yang Sudah Anda Buat
- ✅ Tabel database (`notifications.sql`)
- ✅ Model Notification (`app/model/Notification.php`)
- ✅ Service Worker (`sw.js`)
- ✅ NotificationService (`app/services/NotificationService.php`)
- ✅ Cron job untuk reminder (`cron/send-meal-reminders.php`)
- ✅ Script generate VAPID keys (`scripts/generate-vapid-keys.php`)

## 🚀 Langkah-Langkah Implementasi

### **STEP 1: Install Dependencies** 
```bash
cd c:\xampp\htdocs\healty-app
composer install
```

**Apa yang terjadi:**
- Install library `minishlink/web-push` untuk push notification
- Install library `phpmailer/phpmailer` untuk email notification

---

### **STEP 2: Import Database**

**Cara 1: Via phpMyAdmin (Paling Mudah)**
1. Buka http://localhost/phpmyadmin
2. Pilih database Anda (misal: `healthy_app`)
3. Klik tab **"Import"**
4. Klik **"Choose File"** → Pilih `database/notifications.sql`
5. Klik **"Go"**
6. ✅ Selesai! 3 tabel baru akan dibuat:
   - `push_subscriptions` - Menyimpan subscription push notification
   - `notifications` - Log semua notifikasi yang dikirim
   - `notification_settings` - Pengaturan notifikasi per user

**Cara 2: Via Command Line**
```bash
# Ganti 'your_database' dengan nama database Anda
mysql -u root -p your_database < database/notifications.sql
```

---

### **STEP 3: Generate VAPID Keys**

VAPID keys diperlukan untuk Web Push Notification.

```bash
php scripts/generate-vapid-keys.php
```

**Output akan seperti ini:**
```
===========================================
VAPID Keys Generated Successfully!
===========================================

Copy these to your .env file:

VAPID_PUBLIC_KEY=BEl62iUYgUivxIkv70P1bgeoTfNzG7U...
VAPID_PRIVATE_KEY=bdSiGcHaC-hgq3Na1FZ-BnSKV9FfSl...
VAPID_SUBJECT=mailto:admin@healthyapp.com

===========================================
```

**COPY semua output di atas!**

---

### **STEP 4: Konfigurasi File .env**

1. Buka file `.env` di root project
2. Paste VAPID keys dari step 3
3. Tambahkan konfigurasi email (untuk Gmail):

```env
# VAPID Keys (paste dari step 3)
VAPID_PUBLIC_KEY=BEl62iUYgUivxIkv70P1bgeoTfNzG7U...
VAPID_PRIVATE_KEY=bdSiGcHaC-hgq3Na1FZ-BnSKV9FfSl...
VAPID_SUBJECT=mailto:admin@healthyapp.com

# Email Configuration (SMTP Gmail)
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password-here
MAIL_FROM_ADDRESS=noreply@healthyapp.com
MAIL_FROM_NAME=Healthy App

# Application URL
APP_URL=http://localhost/healty-app
```

**⚠️ PENTING untuk Gmail:**
- Gunakan **App Password**, BUKAN password Gmail biasa
- Cara buat App Password:
  1. Buka https://myaccount.google.com/security
  2. Aktifkan **2-Step Verification**
  3. Cari **"App passwords"**
  4. Generate password untuk "Mail"
  5. Copy password 16 digit → paste ke `MAIL_PASSWORD`

---

### **STEP 5: Test Sistem Notifikasi**

1. **Buka halaman pengaturan notifikasi:**
   ```
   http://localhost/healty-app/views/notification-settings.php
   ```

2. **Aktifkan Push Notification:**
   - Klik tombol **"Aktifkan Push Notification"**
   - Browser akan minta izin → Klik **"Allow"**
   - Status akan berubah menjadi **"Aktif"** ✅

3. **Kirim Test Notification:**
   - Klik tombol **"Kirim Test Notification"**
   - Notifikasi akan muncul di browser! 🎉

4. **Atur Reminder Waktu Makan:**
   - Set waktu untuk Sarapan (default: 07:00)
   - Set waktu untuk Makan Siang (default: 12:00)
   - Set waktu untuk Makan Malam (default: 18:00)
   - Klik **"Simpan Pengaturan"**

---

### **STEP 6: Setup Cron Job (Opsional - Untuk Auto Reminder)**

Cron job akan mengirim reminder otomatis sesuai waktu yang diatur.

**Windows (Task Scheduler):**

1. Buka **Task Scheduler**
2. Klik **"Create Basic Task"**
3. Name: `Healthy App - Meal Reminders`
4. Trigger: **Daily**
5. Action: **Start a program**
   - Program: `C:\xampp\php\php.exe`
   - Arguments: `C:\xampp\htdocs\healty-app\cron\send-meal-reminders.php auto`
6. **Repeat task every:** 1 hour
7. Klik **Finish**

**Linux/Mac (Crontab):**
```bash
crontab -e

# Tambahkan baris ini (jalan setiap jam):
0 * * * * php /path/to/healty-app/cron/send-meal-reminders.php auto
```

**Test Manual (tanpa cron):**
```bash
php cron/send-meal-reminders.php auto
```

---

## 🎯 Fitur yang Didapat

✅ **Web Push Notifications**
- Notifikasi muncul di browser (Chrome, Firefox, Edge)
- Bekerja bahkan saat tab tertutup (jika browser masih buka)
- User bisa klik notifikasi untuk buka aplikasi

✅ **Email Fallback**
- Jika push notification gagal, otomatis kirim email
- Berguna untuk user yang tidak aktifkan push

✅ **Meal Reminders**
- Reminder otomatis untuk sarapan, makan siang, makan malam
- User bisa atur waktu sendiri
- Bisa diaktifkan/nonaktifkan per meal

✅ **User Settings**
- Setiap user punya pengaturan sendiri
- Bisa pilih mau push/email atau keduanya
- Bisa atur waktu reminder sesuai kebiasaan

✅ **Notification Logging**
- Semua notifikasi tercatat di database
- Bisa tracking mana yang berhasil/gagal
- Berguna untuk debugging dan analytics

---

## 🔧 Troubleshooting

### **Push Notification Tidak Muncul?**

**Cek 1: Browser Permission**
- Pastikan browser sudah **Allow** notification
- Chrome: Settings → Privacy → Site Settings → Notifications
- Firefox: Preferences → Privacy → Permissions → Notifications

**Cek 2: VAPID Keys**
- Pastikan VAPID keys di `.env` sudah benar
- Coba generate ulang: `php scripts/generate-vapid-keys.php`

**Cek 3: Service Worker**
- Buka DevTools (F12) → Application → Service Workers
- Pastikan `sw.js` terdaftar dan status **"activated"**

**Cek 4: Browser Support**
- Test di Chrome/Firefox/Edge (Safari tidak support di Windows)

---

### **Email Tidak Terkirim?**

**Cek 1: Gmail App Password**
- HARUS pakai App Password, bukan password biasa
- Pastikan 2FA sudah aktif di Gmail

**Cek 2: SMTP Settings**
```env
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com  # Email lengkap
MAIL_PASSWORD=xxxx xxxx xxxx xxxx   # 16 digit app password
```

**Cek 3: Firewall**
- Pastikan port 587 tidak diblokir firewall

**Cek 4: Spam Folder**
- Cek folder spam di email penerima

---

### **Cron Job Tidak Jalan?**

**Test Manual:**
```bash
php cron/send-meal-reminders.php auto
```

Jika manual berhasil tapi cron tidak:

**Windows:**
- Pastikan path PHP benar: `C:\xampp\php\php.exe`
- Pastikan path script benar
- Cek Task Scheduler history

**Linux/Mac:**
- Cek cron logs: `grep CRON /var/log/syslog`
- Pastikan path PHP benar: `which php`

---

## 📊 Cara Menggunakan di Aplikasi

### **1. Tambahkan Link ke Menu**

Edit file `views/dashboard.php` atau `views/navbar.php`:

```php
<a href="/healty-app/views/notification-settings.php">
    🔔 Pengaturan Notifikasi
</a>
```

### **2. Kirim Notifikasi Custom**

Contoh: Kirim notifikasi saat user berhasil log meal

```php
require_once __DIR__ . '/../app/services/NotificationService.php';

$notificationService = new NotificationService($db);

$notificationService->sendNotification(
    $userId,
    'Meal Logged! 🍽️',
    'Anda berhasil mencatat makan siang hari ini. Total kalori: 650 kcal'
);
```

### **3. Kirim Reminder Manual**

```php
$notificationService->sendMealReminder(
    $userId,
    'breakfast'  // atau 'lunch', 'dinner'
);
```

---

## 📝 Checklist Implementasi

Centang setiap langkah yang sudah selesai:

- [ ] **STEP 1:** Composer install
- [ ] **STEP 2:** Import database
- [ ] **STEP 3:** Generate VAPID keys
- [ ] **STEP 4:** Konfigurasi .env
- [ ] **STEP 5:** Test push notification
- [ ] **STEP 6:** Setup cron job (opsional)
- [ ] **BONUS:** Tambahkan link ke menu

---

## 🎉 Selesai!

Jika semua langkah sudah diikuti, sistem notifikasi Anda sudah **SIAP DIGUNAKAN**!

**Test dengan:**
1. Buka `notification-settings.php`
2. Aktifkan push notification
3. Klik "Kirim Test Notification"
4. Notifikasi muncul → **SUCCESS!** 🎊

---

## 📚 File-File Penting

```
healty-app/
├── database/
│   └── notifications.sql           # ✅ Sudah dibuat
├── app/
│   ├── model/
│   │   └── Notification.php        # ✅ Sudah dibuat
│   └── services/
│       └── NotificationService.php # ✅ Sudah dibuat
├── process/
│   ├── subscribe-push.php          # ✅ Baru dibuat
│   ├── send-test-notification.php  # ✅ Sudah ada
│   └── update-notification-settings.php # ✅ Baru dibuat
├── views/
│   └── notification-settings.php   # ⚠️ Cek apakah sudah ada
├── cron/
│   └── send-meal-reminders.php     # ✅ Sudah dibuat
├── scripts/
│   └── generate-vapid-keys.php     # ✅ Sudah dibuat
├── sw.js                           # ✅ Sudah dibuat
├── .env                            # ⚠️ Perlu dikonfigurasi
└── composer.json                   # ✅ Sudah dibuat
```

---

**Butuh bantuan?** Tanyakan saja! 😊

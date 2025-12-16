---
description: Panduan Lengkap Sistem Notifikasi Healthy App
---

# 🔔 Panduan Sistem Notifikasi Healthy App

## 📋 Ringkasan Sistem

Sistem notifikasi di Healthy App menggunakan **dual-channel approach**:
1. **Web Push Notifications** (prioritas utama) - menggunakan Service Worker & VAPID
2. **Email Notifications** (fallback) - menggunakan PHPMailer

Semua notifikasi dicatat ke database untuk tracking dan analytics.

---

## 🏗️ Arsitektur Sistem

### Komponen Utama:

```
┌─────────────────────────────────────────────────────────┐
│                    USER INTERFACE                       │
│  (notification-settings.php - Pengaturan Notifikasi)   │
└────────────────────┬────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────┐
│              NOTIFICATION SERVICE                       │
│      (NotificationService.php - Logic Layer)            │
└──────────┬──────────────────────────────┬───────────────┘
           │                              │
           ▼                              ▼
┌──────────────────────┐      ┌──────────────────────────┐
│  Push Notification   │      │  Email Notification      │
│  Helper              │      │  Helper                  │
│  (Web Push API)      │      │  (PHPMailer)             │
└──────────┬───────────┘      └───────────┬──────────────┘
           │                              │
           ▼                              ▼
┌──────────────────────────────────────────────────────────┐
│              SERVICE WORKER (sw.js)                      │
│  - Menerima push notifications                           │
│  - Menampilkan notifikasi ke user                        │
│  - Handle click events                                   │
└──────────────────────────────────────────────────────────┘
           │
           ▼
┌──────────────────────────────────────────────────────────┐
│              DATABASE LOGGING                            │
│  - notifications table (log semua notifikasi)            │
│  - push_subscriptions (data subscription user)           │
│  - notification_settings (preferensi user)               │
└──────────────────────────────────────────────────────────┘
```

---

## 🚀 Cara Kerja Sistem

### 1️⃣ **Setup Awal (One-time Setup)**

#### A. Generate VAPID Keys
```bash
# Jalankan script ini SEKALI untuk generate VAPID keys
php scripts/generate-vapid-keys.php
```

Output akan berupa:
```
Public Key: BNxxx...
Private Key: xxx...
```

#### B. Simpan Keys ke .env
Tambahkan ke file `.env`:
```env
VAPID_PUBLIC_KEY=BNxxx...
VAPID_PRIVATE_KEY=xxx...
VAPID_SUBJECT=mailto:admin@healthyapp.com
```

#### C. Setup Database Tables
Tabel sudah ada:
- `push_subscriptions` - menyimpan subscription data dari browser user
- `notifications` - log semua notifikasi yang dikirim
- `notification_settings` - preferensi notifikasi per user

---

### 2️⃣ **User Subscribe ke Push Notifications**

**Flow:**

1. User buka halaman `notification-settings.php`
2. User klik tombol "Subscribe to Push Notifications"
3. Browser meminta permission untuk notifikasi
4. Jika diizinkan:
   - Service Worker (`sw.js`) di-register
   - Browser generate subscription object
   - Subscription dikirim ke server via AJAX
   - Server simpan ke tabel `push_subscriptions`

**Kode JavaScript (sudah ada di notification-settings.php):**
```javascript
// Request permission
Notification.requestPermission()
  .then(permission => {
    if (permission === 'granted') {
      // Subscribe to push
      return registration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
      });
    }
  })
  .then(subscription => {
    // Kirim subscription ke server
    fetch('process/subscribe-push.php', {
      method: 'POST',
      body: JSON.stringify(subscription)
    });
  });
```

---

### 3️⃣ **Mengirim Notifikasi**

#### A. Manual Send (Test Notification)
User bisa test notifikasi dari halaman settings:
```
notification-settings.php → Tombol "Send Test Notification"
  ↓
process/send-test-notification.php
  ↓
NotificationService->sendNotification()
  ↓
1. Cek settings user (push_enabled, email_enabled)
2. Coba kirim via Push dulu
3. Jika gagal, fallback ke Email
4. Log hasil ke database
```

#### B. Automated Meal Reminders (Cron Job)

**Setup Cron Job:**

**Opsi 1: Waktu Spesifik**
```bash
# Breakfast reminder - 07:00 pagi
0 7 * * * php /path/to/healty-app/cron/send-meal-reminders.php breakfast

# Lunch reminder - 12:00 siang
0 12 * * * php /path/to/healty-app/cron/send-meal-reminders.php lunch

# Dinner reminder - 18:00 malam
0 18 * * * php /path/to/healty-app/cron/send-meal-reminders.php dinner
```

**Opsi 2: Auto Mode (Cek setiap menit)**
```bash
# Jalankan setiap menit, script akan cek waktu sendiri
* * * * * php /path/to/healty-app/cron/send-meal-reminders.php auto
```

**Flow Cron Job:**
```
Cron Job Triggered
  ↓
send-meal-reminders.php
  ↓
1. Tentukan meal type (breakfast/lunch/dinner)
2. Query users yang aktif reminder untuk meal type tersebut
3. Loop setiap user:
   - NotificationService->sendMealReminder()
   - Coba push notification
   - Jika gagal, kirim email
   - Log ke database
4. Print summary (success/failed count)
```

---

### 4️⃣ **Service Worker Menerima & Menampilkan Notifikasi**

**Flow di Browser:**

```
Server kirim Push Notification
  ↓
Browser menerima push event
  ↓
Service Worker (sw.js) event listener 'push' triggered
  ↓
Parse data notifikasi
  ↓
self.registration.showNotification(title, options)
  ↓
Notifikasi muncul di device user
  ↓
User klik notifikasi
  ↓
Event 'notificationclick' triggered
  ↓
Buka URL yang ditentukan (misal: pola-makan.php)
```

**Kode di sw.js:**
```javascript
self.addEventListener('push', (event) => {
  let data = event.data.json();
  
  const options = {
    body: data.body,
    icon: '/assets/images/logo-icon.png',
    badge: '/assets/images/badge-icon.png',
    url: data.url || '/views/dashboard.php',
    vibrate: [200, 100, 200]
  };
  
  event.waitUntil(
    self.registration.showNotification(data.title, options)
  );
});
```

---

## 🛠️ Setup & Testing

### Step 1: Generate VAPID Keys
```bash
cd c:\xampp\htdocs\healty-app
php scripts/generate-vapid-keys.php
```

### Step 2: Update .env File
Copy output keys ke `.env`

### Step 3: Install Dependencies (jika belum)
```bash
composer install
```

### Step 4: Test di Browser
1. Buka `http://localhost/healty-app/views/notification-settings.php`
2. Login sebagai user
3. Klik "Subscribe to Push Notifications"
4. Allow permission
5. Klik "Send Test Notification"
6. Notifikasi harus muncul!

### Step 5: Test Cron Job Manual
```bash
# Test breakfast reminder
php cron/send-meal-reminders.php breakfast

# Test auto mode
php cron/send-meal-reminders.php auto
```

### Step 6: Setup Cron Job di Server
Untuk Windows (Task Scheduler):
```
Program: C:\xampp\php\php.exe
Arguments: C:\xampp\htdocs\healty-app\cron\send-meal-reminders.php auto
Schedule: Every 1 minute (atau sesuai kebutuhan)
```

Untuk Linux (crontab):
```bash
crontab -e
# Tambahkan:
* * * * * php /path/to/healty-app/cron/send-meal-reminders.php auto
```

---

## 📊 Monitoring & Logging

### Cek Log Notifikasi di Database
```sql
-- Lihat semua notifikasi yang dikirim
SELECT * FROM notifications 
ORDER BY created_at DESC 
LIMIT 50;

-- Lihat notifikasi per user
SELECT * FROM notifications 
WHERE user_id = 1 
ORDER BY created_at DESC;

-- Statistik success/failed
SELECT 
    notification_type,
    status,
    COUNT(*) as total
FROM notifications
GROUP BY notification_type, status;
```

### Cek Active Subscriptions
```sql
-- Lihat semua active subscriptions
SELECT 
    ps.*,
    u.name,
    u.email
FROM push_subscriptions ps
JOIN users u ON ps.user_id = u.user_id
ORDER BY ps.created_at DESC;
```

---

## 🔧 Troubleshooting

### Problem: Push notification tidak muncul
**Solusi:**
1. Cek browser support: Chrome, Firefox, Edge (Safari iOS tidak support)
2. Cek HTTPS (localhost OK untuk testing)
3. Cek permission di browser settings
4. Cek console browser untuk error
5. Cek VAPID keys sudah benar di .env

### Problem: Email tidak terkirim
**Solusi:**
1. Cek PHPMailer configuration
2. Cek SMTP settings
3. Cek email credentials
4. Cek spam folder

### Problem: Cron job tidak jalan
**Solusi:**
1. Cek path PHP sudah benar
2. Cek file permissions
3. Cek cron log: `/var/log/cron` (Linux)
4. Test manual dulu: `php cron/send-meal-reminders.php auto`

### Problem: Service Worker tidak register
**Solusi:**
1. Cek file `sw.js` accessible
2. Cek console browser
3. Clear browser cache
4. Unregister & register ulang

---

## 📱 Testing Checklist

- [ ] VAPID keys generated dan disimpan di .env
- [ ] User bisa subscribe ke push notifications
- [ ] Test notification berhasil dikirim dan muncul
- [ ] Klik notification membuka URL yang benar
- [ ] Email fallback bekerja jika push gagal
- [ ] Notification settings bisa disimpan
- [ ] Meal reminders bisa dikirim manual
- [ ] Cron job berjalan otomatis
- [ ] Notifikasi tercatat di database
- [ ] Expired subscriptions dihapus otomatis

---

## 🎯 Use Cases

### 1. Meal Reminder
```php
$notificationService->sendMealReminder(
    $userId,
    $userEmail,
    $userName,
    'breakfast' // atau 'lunch', 'dinner'
);
```

### 2. Custom Notification
```php
$notificationService->sendNotification(
    $userId,
    $userEmail,
    $userName,
    'Selamat! 🎉',
    'Anda telah mencapai target kalori hari ini!',
    '/views/dashboard.php'
);
```

### 3. Bulk Notification
```php
$users = [
    ['user_id' => 1, 'email' => 'user1@example.com', 'name' => 'User 1'],
    ['user_id' => 2, 'email' => 'user2@example.com', 'name' => 'User 2'],
];

$notificationService->sendBulkNotifications(
    $users,
    'Pengumuman Penting',
    'Sistem akan maintenance besok pukul 02:00',
    '/views/dashboard.php'
);
```

---

## 🔐 Security Notes

1. **VAPID Keys**: Jangan commit ke Git! Simpan di `.env` dan tambahkan ke `.gitignore`
2. **Subscription Data**: Encrypted di browser, aman untuk disimpan
3. **User Permissions**: Selalu cek user sudah login sebelum kirim notifikasi
4. **Rate Limiting**: Pertimbangkan batasi jumlah notifikasi per user per hari

---

## 📚 Resources

- [Web Push API Documentation](https://developer.mozilla.org/en-US/docs/Web/API/Push_API)
- [Service Worker Guide](https://developer.mozilla.org/en-US/docs/Web/API/Service_Worker_API)
- [web-push-php Library](https://github.com/web-push-libs/web-push-php)
- [PHPMailer Documentation](https://github.com/PHPMailer/PHPMailer)

---

**Dibuat untuk Healthy App Project**
*Last Updated: 2025-12-16*

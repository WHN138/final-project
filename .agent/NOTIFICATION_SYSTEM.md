# 🔔 Sistem Notifikasi Lengkap - Healthy App

## 📋 Overview

Sistem notifikasi lengkap dengan:
1. **Web Push Notification** (Service Worker + VAPID)
2. **Email Fallback** (PHPMailer) jika push tidak didukung
3. **Database Logging** untuk tracking semua notifikasi
4. **Meal Reminders** otomatis dengan cron job
5. **User Settings** untuk kontrol penuh

---

## 🗄️ Database Structure

### 1. `push_subscriptions`
Menyimpan subscription push notification dari browser user.

```sql
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- user_id (INT, FOREIGN KEY)
- endpoint (TEXT) - Push endpoint URL
- p256dh (VARCHAR 255) - Encryption key
- auth (VARCHAR 255) - Authentication secret
- created_at (TIMESTAMP)
```

### 2. `notifications`
Log semua notifikasi yang dikirim.

```sql
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- user_id (INT, FOREIGN KEY)
- type (ENUM: 'push', 'email')
- title (VARCHAR 255)
- message (TEXT)
- status (ENUM: 'sent', 'failed', 'pending')
- error_message (TEXT, NULLABLE)
- sent_at (TIMESTAMP, NULLABLE)
- created_at (TIMESTAMP)
```

### 3. `notification_settings`
Pengaturan notifikasi per user.

```sql
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- user_id (INT, FOREIGN KEY, UNIQUE)
- push_enabled (BOOLEAN, DEFAULT TRUE)
- email_enabled (BOOLEAN, DEFAULT TRUE)
- reminder_breakfast (BOOLEAN, DEFAULT TRUE)
- reminder_lunch (BOOLEAN, DEFAULT TRUE)
- reminder_dinner (BOOLEAN, DEFAULT TRUE)
- reminder_time_breakfast (TIME, DEFAULT '07:00:00')
- reminder_time_lunch (TIME, DEFAULT '12:00:00')
- reminder_time_dinner (TIME, DEFAULT '18:00:00')
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

---

## 📁 File Structure

```
healty-app/
├── sw.js                                    # Service Worker
├── composer.json                            # Dependencies
├── .env.example                             # Environment variables template
│
├── app/
│   ├── model/
│   │   └── Notification.php                 # Notification model
│   ├── services/
│   │   └── NotificationService.php          # Main notification service
│   └── helpers/
│       ├── PushNotificationHelper.php       # Web Push helper
│       └── EmailNotificationHelper.php      # Email helper
│
├── process/
│   ├── push-subscription.php                # Subscribe/unsubscribe API
│   ├── send-test-notification.php           # Test notification API
│   └── save-notification-settings.php       # Save settings API
│
├── views/
│   └── notification-settings.php            # Settings page
│
├── cron/
│   └── send-meal-reminders.php              # Cron job for reminders
│
├── scripts/
│   └── generate-vapid-keys.php              # Generate VAPID keys
│
└── database/
    └── notifications.sql                    # Database schema
```

---

## 🚀 Installation & Setup

### Step 1: Install Dependencies

```bash
cd c:\xampp\htdocs\healty-app
composer install
```

Ini akan menginstall:
- `minishlink/web-push` - Library untuk Web Push
- `phpmailer/phpmailer` - Library untuk Email

### Step 2: Generate VAPID Keys

```bash
php scripts/generate-vapid-keys.php
```

Output akan seperti ini:
```
=== Public Key ===
BEl62iUYgUivxIkv69yViEuiBIa-Ib27SzV8kFj_VCOTjWJlD3-...

=== Private Key ===
bdSiGcHaC-hgq3Na1plzA9yUjZD6tqnQepjqUkJ7OmI

=== Add these to your .env file ===
VAPID_PUBLIC_KEY=BEl62iUYgUivxIkv69yViEuiBIa-Ib27SzV8kFj_VCOTjWJlD3-...
VAPID_PRIVATE_KEY=bdSiGcHaC-hgq3Na1plzA9yUjZD6tqnQepjqUkJ7OmI
```

### Step 3: Configure Environment

Copy `.env.example` to `.env` dan isi dengan data Anda:

```bash
cp .env.example .env
```

Edit `.env`:
```env
# VAPID Keys (dari step 2)
VAPID_PUBLIC_KEY=your_generated_public_key
VAPID_PRIVATE_KEY=your_generated_private_key
VAPID_SUBJECT=mailto:admin@healthyapp.com

# Email Configuration (Gmail example)
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=noreply@healthyapp.com
MAIL_FROM_NAME=Healthy App

# Application URL
APP_URL=http://localhost/healty-app
```

**Note untuk Gmail:**
- Gunakan App Password, bukan password biasa
- Enable 2-Factor Authentication
- Generate App Password di: https://myaccount.google.com/apppasswords

### Step 4: Import Database

```sql
-- Import schema
mysql -u root -p your_database < database/notifications.sql

-- Atau via phpMyAdmin:
-- 1. Buka phpMyAdmin
-- 2. Pilih database Anda
-- 3. Tab "Import"
-- 4. Pilih file database/notifications.sql
-- 5. Klik "Go"
```

### Step 5: Setup Cron Job (Optional - untuk auto reminders)

**Windows (Task Scheduler):**
1. Buka Task Scheduler
2. Create Basic Task
3. Trigger: Daily
4. Action: Start a program
5. Program: `C:\xampp\php\php.exe`
6. Arguments: `C:\xampp\htdocs\healty-app\cron\send-meal-reminders.php auto`
7. Repeat task every: 1 hour

**Linux/Mac (Crontab):**
```bash
# Edit crontab
crontab -e

# Add these lines:
# Check every hour for reminders
0 * * * * php /path/to/healty-app/cron/send-meal-reminders.php auto

# Or specific times:
0 7 * * * php /path/to/healty-app/cron/send-meal-reminders.php breakfast
0 12 * * * php /path/to/healty-app/cron/send-meal-reminders.php lunch
0 18 * * * php /path/to/healty-app/cron/send-meal-reminders.php dinner
```

---

## 💻 Usage

### 1. User Settings Page

User bisa mengakses pengaturan di: `views/notification-settings.php`

**Fitur:**
- ✅ Enable/disable push notifications
- ✅ Enable/disable email notifications
- ✅ Subscribe/unsubscribe push
- ✅ Set meal reminder times
- ✅ Test notification button

### 2. Send Notification Programmatically

```php
<?php
require_once 'app/services/NotificationService.php';

$notificationService = new NotificationService();

// Send notification to user
$result = $notificationService->sendNotification(
    $userId,           // User ID
    $userEmail,        // User email
    $userName,         // User name
    'Judul Notifikasi', // Title
    'Pesan notifikasi', // Message
    '/views/page.php'  // Optional: URL to open
);

if ($result['success']) {
    echo "Notification sent via " . $result['method']; // 'push' or 'email'
} else {
    echo "Failed: " . $result['message'];
}
?>
```

### 3. Send Meal Reminder

```php
<?php
$result = $notificationService->sendMealReminder(
    $userId,
    $userEmail,
    $userName,
    'breakfast' // 'breakfast', 'lunch', or 'dinner'
);
?>
```

### 4. Send Bulk Notifications

```php
<?php
$users = [
    ['user_id' => 1, 'email' => 'user1@example.com', 'name' => 'User 1'],
    ['user_id' => 2, 'email' => 'user2@example.com', 'name' => 'User 2'],
];

$results = $notificationService->sendBulkNotifications(
    $users,
    'Announcement',
    'This is a bulk notification',
    '/views/announcement.php'
);
?>
```

---

## 🔄 How It Works

### Push Notification Flow

```
1. User visits notification-settings.php
   ↓
2. Service Worker (sw.js) registered
   ↓
3. User clicks "Subscribe to Push"
   ↓
4. Browser requests permission
   ↓
5. If granted, subscription created with VAPID keys
   ↓
6. Subscription saved to database (push_subscriptions table)
   ↓
7. When notification sent:
   - Server sends push via web-push library
   - Service Worker receives push event
   - Browser shows notification
   ↓
8. User clicks notification → Opens specified URL
```

### Email Fallback Flow

```
1. Notification service tries push first
   ↓
2. If push fails or no subscription:
   - Falls back to email
   - Uses PHPMailer to send SMTP email
   - HTML template with branding
   ↓
3. All attempts logged to notifications table
```

### Meal Reminder Flow

```
1. Cron job runs (hourly or at specific times)
   ↓
2. Checks current time
   ↓
3. Queries users with matching reminder time
   ↓
4. For each user:
   - Check notification settings
   - Send via push (if enabled)
   - Fallback to email (if push fails)
   - Log to database
   ↓
5. Summary report generated
```

---

## 🎨 Customization

### Custom Email Template

Edit `app/helpers/EmailNotificationHelper.php`:

```php
private function getReminderTemplate($name, $mealType)
{
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <!-- Your custom styles -->
    </head>
    <body>
        <!-- Your custom HTML -->
    </body>
    </html>
    ";
}
```

### Custom Push Notification

Edit payload in `app/services/NotificationService.php`:

```php
$payload = [
    'title' => $title,
    'body' => $message,
    'icon' => '/assets/images/custom-icon.png',
    'badge' => '/assets/images/custom-badge.png',
    'url' => $url,
    'tag' => 'custom-tag',
    'requireInteraction' => true, // Keep notification until user interacts
    'actions' => [
        ['action' => 'view', 'title' => 'View'],
        ['action' => 'dismiss', 'title' => 'Dismiss']
    ]
];
```

---

## 🧪 Testing

### Test Push Notification

1. Buka `notification-settings.php`
2. Subscribe to push notifications
3. Klik "Kirim Test Notification"
4. Notification akan muncul di browser

### Test Email

1. Pastikan SMTP configured di `.env`
2. Disable push notifications di settings
3. Klik "Kirim Test Notification"
4. Email akan dikirim ke alamat user

### Test Cron Job

```bash
# Manual run
php cron/send-meal-reminders.php breakfast

# Check output
# Should show: "Found X users for breakfast reminder..."
```

---

## 📊 Monitoring & Logs

### View Notification Logs

```php
<?php
$notificationModel = new Notification();
$logs = $notificationModel->getUserNotifications($userId, 50);

foreach ($logs as $log) {
    echo "{$log['type']}: {$log['title']} - {$log['status']}\n";
    if ($log['status'] === 'failed') {
        echo "Error: {$log['error_message']}\n";
    }
}
?>
```

### Database Queries

```sql
-- Total notifications sent today
SELECT COUNT(*) FROM notifications 
WHERE DATE(created_at) = CURDATE() 
AND status = 'sent';

-- Failed notifications
SELECT * FROM notifications 
WHERE status = 'failed' 
ORDER BY created_at DESC 
LIMIT 10;

-- Push vs Email ratio
SELECT type, COUNT(*) as count 
FROM notifications 
WHERE status = 'sent' 
GROUP BY type;

-- Active push subscriptions
SELECT COUNT(DISTINCT user_id) 
FROM push_subscriptions;
```

---

## 🔒 Security

### VAPID Keys
- ✅ Private key harus disimpan di `.env` (tidak di version control)
- ✅ Public key bisa di-expose ke client
- ✅ Subject harus valid email atau URL

### Email
- ✅ Gunakan App Password untuk Gmail
- ✅ Enable 2FA
- ✅ Jangan hardcode password di code

### Subscriptions
- ✅ Verify user_id sebelum save/delete subscription
- ✅ Clean up expired subscriptions otomatis
- ✅ Rate limiting untuk prevent spam

---

## 🐛 Troubleshooting

### Push Notification Tidak Muncul

**Problem:** Subscription berhasil tapi notification tidak muncul

**Solutions:**
1. Check browser console untuk error
2. Verify VAPID keys correct
3. Check service worker registered: `navigator.serviceWorker.ready`
4. Test di browser lain (Chrome/Firefox recommended)
5. Check notification permission: `Notification.permission`

### Email Tidak Terkirim

**Problem:** Email notification failed

**Solutions:**
1. Check SMTP credentials di `.env`
2. Verify port (587 untuk TLS, 465 untuk SSL)
3. Check firewall tidak block SMTP
4. Enable "Less secure app access" (Gmail)
5. Use App Password instead of regular password
6. Check spam folder

### Cron Job Tidak Jalan

**Problem:** Reminders tidak dikirim otomatis

**Solutions:**
1. Check cron job configured correctly
2. Verify PHP path correct
3. Check file permissions (executable)
4. Test manual run: `php cron/send-meal-reminders.php auto`
5. Check cron logs: `/var/log/cron` (Linux)

### Service Worker Error

**Problem:** Service Worker registration failed

**Solutions:**
1. Must be served over HTTPS (or localhost)
2. Check `sw.js` path correct (root directory)
3. Clear browser cache
4. Check browser console for errors
5. Verify browser supports Service Workers

---

## 📈 Performance Tips

1. **Batch Notifications**: Send bulk notifications in batches
2. **Queue System**: Use queue for large number of notifications
3. **Cleanup**: Regularly delete old notification logs
4. **Index**: Add indexes on frequently queried columns
5. **Cache**: Cache user settings to reduce DB queries

---

## 🎯 Features Summary

| Feature | Status | Description |
|---------|--------|-------------|
| **Web Push** | ✅ | Browser push notifications dengan VAPID |
| **Email Fallback** | ✅ | Otomatis fallback ke email jika push gagal |
| **Database Logging** | ✅ | Log semua notifikasi dengan status |
| **User Settings** | ✅ | Kontrol penuh untuk user |
| **Meal Reminders** | ✅ | Auto reminder dengan cron job |
| **Test Function** | ✅ | Test notification dari UI |
| **Bulk Send** | ✅ | Kirim ke multiple users |
| **HTML Email** | ✅ | Beautiful email templates |
| **Error Handling** | ✅ | Comprehensive error handling |
| **Security** | ✅ | User verification & encryption |

---

## 📝 Next Steps

1. ✅ Install dependencies (`composer install`)
2. ✅ Generate VAPID keys
3. ✅ Configure `.env`
4. ✅ Import database schema
5. ✅ Test push notification
6. ✅ Test email notification
7. ✅ Setup cron job (optional)
8. ✅ Customize templates (optional)

---

## 🆘 Support

Jika ada masalah atau pertanyaan:
1. Check troubleshooting section
2. Review error logs di database
3. Check browser console
4. Verify environment configuration

**Sistem notifikasi sudah lengkap dan siap digunakan!** 🎉

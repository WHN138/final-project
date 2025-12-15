# 🚀 Quick Start - Notification System

## ⚡ Setup dalam 5 Menit

### 1️⃣ Install Dependencies (2 menit)

```bash
cd c:\xampp\htdocs\healty-app
composer install
```

### 2️⃣ Generate VAPID Keys (30 detik)

```bash
php scripts/generate-vapid-keys.php
```

Copy output ke `.env` file.

### 3️⃣ Configure .env (1 menit)

```env
# VAPID Keys (paste dari step 2)
VAPID_PUBLIC_KEY=BEl62iUYgUivxIkv...
VAPID_PRIVATE_KEY=bdSiGcHaC-hgq3Na...
VAPID_SUBJECT=mailto:admin@healthyapp.com

# Gmail SMTP
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=noreply@healthyapp.com
MAIL_FROM_NAME=Healthy App

# App URL
APP_URL=http://localhost/healty-app
```

### 4️⃣ Import Database (1 menit)

**Via phpMyAdmin:**
1. Buka http://localhost/phpmyadmin
2. Pilih database Anda
3. Tab "Import"
4. Pilih `database/notifications.sql`
5. Klik "Go"

**Via Command Line:**
```bash
mysql -u root -p your_database < database/notifications.sql
```

### 5️⃣ Test! (30 detik)

1. Buka: `http://localhost/healty-app/views/notification-settings.php`
2. Klik "Subscribe to Push Notifications"
3. Allow permission
4. Klik "Kirim Test Notification"
5. 🎉 Done!

---

## 📋 Checklist

- [ ] Composer dependencies installed
- [ ] VAPID keys generated
- [ ] .env configured
- [ ] Database tables created
- [ ] Test notification works

---

## 🎯 What You Get

✅ **Web Push Notifications** - Browser notifications  
✅ **Email Fallback** - Auto fallback jika push gagal  
✅ **Meal Reminders** - Auto reminder sarapan/makan siang/malam  
✅ **User Settings** - Full control untuk user  
✅ **Logging** - Track semua notifikasi  

---

## 🔧 Optional: Setup Cron Job

**Windows Task Scheduler:**
- Program: `C:\xampp\php\php.exe`
- Arguments: `C:\xampp\htdocs\healty-app\cron\send-meal-reminders.php auto`
- Trigger: Hourly

**Linux/Mac:**
```bash
crontab -e
# Add:
0 * * * * php /path/to/healty-app/cron/send-meal-reminders.php auto
```

---

## 📚 Full Documentation

Lihat `NOTIFICATION_SYSTEM.md` untuk dokumentasi lengkap.

---

## ⚠️ Common Issues

**Push tidak muncul?**
- Check browser permission
- Verify VAPID keys correct
- Test di Chrome/Firefox

**Email tidak terkirim?**
- Use Gmail App Password (bukan password biasa)
- Enable 2FA di Gmail
- Check spam folder

**Cron job tidak jalan?**
- Test manual: `php cron/send-meal-reminders.php auto`
- Check PHP path
- Verify file permissions

---

**Ready to go!** 🚀

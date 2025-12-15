# Install Dependencies Manual (Tanpa Composer)

## ⚠️ TIDAK RECOMMENDED
Cara ini lebih ribet dan tidak recommended. Lebih baik install Composer.

## Jika Tetap Ingin Manual:

### 1. Download Library Web Push

1. Buka: https://github.com/web-push-libs/web-push-php/releases
2. Download versi terbaru (ZIP)
3. Extract ke folder: `c:\xampp\htdocs\healty-app\vendor\minishlink\web-push\`

### 2. Download PHPMailer

1. Buka: https://github.com/PHPMailer/PHPMailer/releases
2. Download versi terbaru (ZIP)
3. Extract ke folder: `c:\xampp\htdocs\healty-app\vendor\phpmailer\phpmailer\`

### 3. Download Dependencies Lainnya

Web Push membutuhkan beberapa library tambahan:
- `web-token/jwt-core`
- `web-token/jwt-signature`
- `guzzlehttp/guzzle`
- Dan beberapa lainnya...

**MASALAHNYA:** Setiap library punya dependencies sendiri, jadi Anda harus download puluhan library secara manual. Ini sangat tidak efisien!

## Kesimpulan

**SANGAT DISARANKAN untuk install Composer** karena:
- ✅ Otomatis download semua dependencies
- ✅ Mudah update
- ✅ Standard di industri PHP
- ✅ Hanya butuh 1 command: `composer install`

Tanpa Composer, Anda harus download dan setup **15+ library** secara manual!

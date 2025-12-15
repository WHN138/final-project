<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailNotificationHelper
{
    private $mailer;
    private $fromEmail;
    private $fromName;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        
        // Load from .env or config
        $this->fromEmail = getenv('MAIL_FROM_ADDRESS') ?: 'noreply@healthyapp.com';
        $this->fromName = getenv('MAIL_FROM_NAME') ?: 'Healthy App';

        // SMTP Configuration
        $this->mailer->isSMTP();
        $this->mailer->Host = getenv('MAIL_HOST') ?: 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = getenv('MAIL_USERNAME') ?: 'your-email@gmail.com';
        $this->mailer->Password = getenv('MAIL_PASSWORD') ?: 'your-app-password';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = getenv('MAIL_PORT') ?: 587;
        
        // Set from
        $this->mailer->setFrom($this->fromEmail, $this->fromName);
        
        // Encoding
        $this->mailer->CharSet = 'UTF-8';
    }

    /**
     * Send email notification
     */
    public function sendEmail($toEmail, $toName, $subject, $body, $isHTML = true)
    {
        try {
            // Recipients
            $this->mailer->addAddress($toEmail, $toName);

            // Content
            $this->mailer->isHTML($isHTML);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            
            if ($isHTML) {
                // Alternative plain text
                $this->mailer->AltBody = strip_tags($body);
            }

            $this->mailer->send();
            
            // Clear addresses for next email
            $this->mailer->clearAddresses();
            
            return [
                'success' => true,
                'message' => 'Email sent successfully'
            ];
        } catch (Exception $e) {
            // Clear addresses even on error
            $this->mailer->clearAddresses();
            
            return [
                'success' => false,
                'message' => 'Email failed: ' . $this->mailer->ErrorInfo
            ];
        }
    }

    /**
     * Send reminder email with template
     */
    public function sendReminderEmail($toEmail, $toName, $mealType)
    {
        $mealLabels = [
            'breakfast' => 'Sarapan',
            'lunch' => 'Makan Siang',
            'dinner' => 'Makan Malam'
        ];

        $mealLabel = $mealLabels[$mealType] ?? 'Makan';
        
        $subject = "Reminder: Waktunya $mealLabel! 🍽️";
        
        $body = $this->getReminderTemplate($toName, $mealLabel);
        
        return $this->sendEmail($toEmail, $toName, $subject, $body, true);
    }

    /**
     * Get HTML template for reminder email
     */
    private function getReminderTemplate($name, $mealType)
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                }
                .container {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    border-radius: 15px;
                    padding: 30px;
                    color: white;
                    text-align: center;
                }
                .icon {
                    font-size: 60px;
                    margin-bottom: 20px;
                }
                h1 {
                    margin: 0 0 10px 0;
                    font-size: 28px;
                }
                p {
                    font-size: 16px;
                    margin: 15px 0;
                }
                .button {
                    display: inline-block;
                    padding: 12px 30px;
                    background: white;
                    color: #667eea;
                    text-decoration: none;
                    border-radius: 25px;
                    font-weight: bold;
                    margin-top: 20px;
                }
                .footer {
                    margin-top: 30px;
                    padding-top: 20px;
                    border-top: 1px solid rgba(255,255,255,0.3);
                    font-size: 14px;
                    opacity: 0.9;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='icon'>🍽️</div>
                <h1>Halo, $name!</h1>
                <p>Waktunya <strong>$mealType</strong>! Jangan lupa untuk mencatat makanan Anda hari ini.</p>
                <p>Menjaga pola makan yang teratur adalah kunci hidup sehat! 💪</p>
                <a href='" . getenv('APP_URL') . "/views/pola-makan.php' class='button'>
                    Catat Makanan Sekarang
                </a>
                <div class='footer'>
                    <p>Healthy App - Your Health Companion</p>
                    <p style='font-size: 12px;'>Anda menerima email ini karena Anda mengaktifkan reminder di pengaturan notifikasi.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }

    /**
     * Send custom notification email
     */
    public function sendNotificationEmail($toEmail, $toName, $title, $message, $actionUrl = null)
    {
        $subject = $title;
        $body = $this->getNotificationTemplate($toName, $title, $message, $actionUrl);
        
        return $this->sendEmail($toEmail, $toName, $subject, $body, true);
    }

    /**
     * Get HTML template for general notification
     */
    private function getNotificationTemplate($name, $title, $message, $actionUrl = null)
    {
        $actionButton = '';
        if ($actionUrl) {
            $actionButton = "<a href='$actionUrl' class='button'>Lihat Detail</a>";
        }

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                }
                .container {
                    background: #f8f9fa;
                    border-radius: 10px;
                    padding: 30px;
                    border-left: 5px solid #7366ff;
                }
                h2 {
                    color: #7366ff;
                    margin-top: 0;
                }
                .button {
                    display: inline-block;
                    padding: 10px 25px;
                    background: #7366ff;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    margin-top: 15px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>$title</h2>
                <p>Halo $name,</p>
                <p>$message</p>
                $actionButton
                <hr style='margin: 20px 0; border: none; border-top: 1px solid #ddd;'>
                <p style='font-size: 12px; color: #666;'>Healthy App - Your Health Companion</p>
            </div>
        </body>
        </html>
        ";
    }
}
?>

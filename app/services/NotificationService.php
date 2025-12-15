<?php
require_once __DIR__ . '/../model/Notification.php';
require_once __DIR__ . '/../helpers/PushNotificationHelper.php';
require_once __DIR__ . '/../helpers/EmailNotificationHelper.php';

class NotificationService
{
    private $notificationModel;
    private $pushHelper;
    private $emailHelper;

    public function __construct()
    {
        $this->notificationModel = new Notification();
        $this->pushHelper = new PushNotificationHelper();
        $this->emailHelper = new EmailNotificationHelper();
    }

    /**
     * Send notification to user (tries push first, falls back to email)
     */
    public function sendNotification($userId, $userEmail, $userName, $title, $message, $url = null)
    {
        $settings = $this->notificationModel->getSettings($userId);
        $sent = false;
        $method = null;

        // Try push notification first if enabled
        if ($settings['push_enabled']) {
            $pushResult = $this->sendPushNotification($userId, $title, $message, $url);
            if ($pushResult['success']) {
                $sent = true;
                $method = 'push';
                $this->notificationModel->logNotification($userId, 'push', $title, $message, 'sent');
            } else {
                $this->notificationModel->logNotification($userId, 'push', $title, $message, 'failed', $pushResult['message']);
            }
        }

        // Fallback to email if push failed or disabled
        if (!$sent && $settings['email_enabled']) {
            $emailResult = $this->sendEmailNotification($userEmail, $userName, $title, $message, $url);
            if ($emailResult['success']) {
                $sent = true;
                $method = 'email';
                $this->notificationModel->logNotification($userId, 'email', $title, $message, 'sent');
            } else {
                $this->notificationModel->logNotification($userId, 'email', $title, $message, 'failed', $emailResult['message']);
            }
        }

        return [
            'success' => $sent,
            'method' => $method,
            'message' => $sent ? "Notification sent via $method" : 'All notification methods failed'
        ];
    }

    /**
     * Send push notification to user
     */
    private function sendPushNotification($userId, $title, $message, $url = null)
    {
        $subscriptions = $this->notificationModel->getUserSubscriptions($userId);
        
        if (empty($subscriptions)) {
            return [
                'success' => false,
                'message' => 'No push subscriptions found'
            ];
        }

        $payload = [
            'title' => $title,
            'body' => $message,
            'icon' => '/assets/images/logo-icon.png',
            'badge' => '/assets/images/badge-icon.png',
            'url' => $url ?: '/views/dashboard.php',
            'tag' => 'notification-' . time(),
            'requireInteraction' => false
        ];

        $results = $this->pushHelper->sendPushToMultiple($subscriptions, $payload);
        
        // Check if at least one succeeded
        $anySuccess = false;
        foreach ($results as $result) {
            if ($result['result']['success']) {
                $anySuccess = true;
                break;
            }
            
            // Remove expired subscriptions
            if (isset($result['result']['expired']) && $result['result']['expired']) {
                $this->notificationModel->deleteSubscription($userId, $result['endpoint']);
            }
        }

        return [
            'success' => $anySuccess,
            'message' => $anySuccess ? 'Push sent to at least one device' : 'All push attempts failed',
            'results' => $results
        ];
    }

    /**
     * Send email notification
     */
    private function sendEmailNotification($email, $name, $title, $message, $url = null)
    {
        return $this->emailHelper->sendNotificationEmail($email, $name, $title, $message, $url);
    }

    /**
     * Send meal reminder
     */
    public function sendMealReminder($userId, $userEmail, $userName, $mealType)
    {
        $settings = $this->notificationModel->getSettings($userId);
        
        $mealLabels = [
            'breakfast' => 'Sarapan',
            'lunch' => 'Makan Siang',
            'dinner' => 'Makan Malam'
        ];

        $mealLabel = $mealLabels[$mealType] ?? 'Makan';
        $title = "Waktunya $mealLabel! 🍽️";
        $message = "Jangan lupa untuk mencatat makanan Anda hari ini. Menjaga pola makan yang teratur adalah kunci hidup sehat!";
        $url = '/views/pola-makan.php';

        return $this->sendNotification($userId, $userEmail, $userName, $title, $message, $url);
    }

    /**
     * Send bulk notifications to multiple users
     */
    public function sendBulkNotifications($users, $title, $message, $url = null)
    {
        $results = [];
        
        foreach ($users as $user) {
            $result = $this->sendNotification(
                $user['user_id'],
                $user['email'],
                $user['name'],
                $title,
                $message,
                $url
            );
            
            $results[] = [
                'user_id' => $user['user_id'],
                'result' => $result
            ];
        }

        return $results;
    }

    /**
     * Get VAPID public key for client
     */
    public function getVapidPublicKey()
    {
        return $this->pushHelper->getPublicKey();
    }
}
?>

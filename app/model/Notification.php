<?php
class Notification
{
    private $db;

    public function __construct()
    {
        if (!class_exists('Database')) {
            include "../app/config/database.php";
        }
        $this->db = (new Database())->connect();
    }

    // Save push subscription
    public function savePushSubscription($userId, $endpoint, $p256dh, $auth)
    {
        // Check if subscription already exists
        $stmt = $this->db->prepare("SELECT id FROM push_subscriptions WHERE user_id = ? AND endpoint = ?");
        $stmt->execute([$userId, $endpoint]);
        
        if ($stmt->fetch()) {
            // Update existing
            $stmt = $this->db->prepare("UPDATE push_subscriptions SET p256dh = ?, auth = ? WHERE user_id = ? AND endpoint = ?");
            return $stmt->execute([$p256dh, $auth, $userId, $endpoint]);
        } else {
            // Insert new
            $stmt = $this->db->prepare("INSERT INTO push_subscriptions (user_id, endpoint, p256dh, auth) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$userId, $endpoint, $p256dh, $auth]);
        }
    }

    // Get user subscriptions
    public function getUserSubscriptions($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM push_subscriptions WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete subscription
    public function deleteSubscription($userId, $endpoint)
    {
        $stmt = $this->db->prepare("DELETE FROM push_subscriptions WHERE user_id = ? AND endpoint = ?");
        return $stmt->execute([$userId, $endpoint]);
    }

    // Log notification
    public function logNotification($userId, $type, $title, $message, $status = 'pending', $errorMessage = null)
    {
        $stmt = $this->db->prepare("INSERT INTO notifications (user_id, type, title, message, status, error_message, sent_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sentAt = ($status === 'sent') ? date('Y-m-d H:i:s') : null;
        return $stmt->execute([$userId, $type, $title, $message, $status, $errorMessage, $sentAt]);
    }

    // Update notification status
    public function updateNotificationStatus($notificationId, $status, $errorMessage = null)
    {
        $stmt = $this->db->prepare("UPDATE notifications SET status = ?, error_message = ?, sent_at = ? WHERE id = ?");
        $sentAt = ($status === 'sent') ? date('Y-m-d H:i:s') : null;
        return $stmt->execute([$status, $errorMessage, $sentAt, $notificationId]);
    }

    // Get user notifications
    public function getUserNotifications($userId, $limit = 50)
    {
        $stmt = $this->db->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get notification settings
    public function getSettings($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM notification_settings WHERE user_id = ?");
        $stmt->execute([$userId]);
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Create default settings if not exists
        if (!$settings) {
            $this->createDefaultSettings($userId);
            return $this->getSettings($userId);
        }
        
        return $settings;
    }

    // Create default settings
    private function createDefaultSettings($userId)
    {
        $stmt = $this->db->prepare("INSERT INTO notification_settings (user_id) VALUES (?)");
        return $stmt->execute([$userId]);
    }

    // Update settings
    public function updateSettings($userId, $settings)
    {
        $fields = [];
        $values = [];
        
        foreach ($settings as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        
        $values[] = $userId;
        $sql = "UPDATE notification_settings SET " . implode(', ', $fields) . " WHERE user_id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    // Get users who need reminders at specific time
    public function getUsersForReminder($mealType, $time)
    {
        $timeField = "reminder_time_" . $mealType;
        $enabledField = "reminder_" . $mealType;
        
        $stmt = $this->db->prepare("
            SELECT ns.user_id, u.email, u.name 
            FROM notification_settings ns
            JOIN users u ON ns.user_id = u.id
            WHERE ns.$enabledField = 1 
            AND ns.$timeField = ?
            AND (ns.push_enabled = 1 OR ns.email_enabled = 1)
        ");
        $stmt->execute([$time]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Alias methods for API compatibility
    public function saveSubscription($userId, $endpoint, $p256dh, $auth)
    {
        return $this->savePushSubscription($userId, $endpoint, $p256dh, $auth);
    }

    public function getNotificationSettings($userId)
    {
        return $this->getSettings($userId);
    }

    public function updateNotificationSettings($userId, $settings)
    {
        return $this->updateSettings($userId, $settings);
    }
}
?>

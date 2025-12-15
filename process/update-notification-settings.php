<?php
session_start();
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/model/Notification.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    $db = getDBConnection();
    $notification = new Notification($db);
    
    // Update notification settings
    $result = $notification->updateNotificationSettings($userId, [
        'email_enabled' => $input['email_enabled'] ?? 1,
        'reminder_breakfast' => $input['reminder_breakfast'] ?? 1,
        'reminder_lunch' => $input['reminder_lunch'] ?? 1,
        'reminder_dinner' => $input['reminder_dinner'] ?? 1,
        'reminder_time_breakfast' => $input['reminder_time_breakfast'] ?? '07:00:00',
        'reminder_time_lunch' => $input['reminder_time_lunch'] ?? '12:00:00',
        'reminder_time_dinner' => $input['reminder_time_dinner'] ?? '18:00:00'
    ]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Settings updated successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update settings'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

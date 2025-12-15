<?php
session_start();
header('Content-Type: application/json');

require_once '../app/model/Notification.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings = [
        'push_enabled' => isset($_POST['push_enabled']) ? 1 : 0,
        'email_enabled' => isset($_POST['email_enabled']) ? 1 : 0,
        'reminder_breakfast' => isset($_POST['reminder_breakfast']) ? 1 : 0,
        'reminder_lunch' => isset($_POST['reminder_lunch']) ? 1 : 0,
        'reminder_dinner' => isset($_POST['reminder_dinner']) ? 1 : 0,
        'reminder_time_breakfast' => $_POST['reminder_time_breakfast'] ?? '07:00:00',
        'reminder_time_lunch' => $_POST['reminder_time_lunch'] ?? '12:00:00',
        'reminder_time_dinner' => $_POST['reminder_time_dinner'] ?? '18:00:00'
    ];
    
    $notificationModel = new Notification();
    $result = $notificationModel->updateSettings($userId, $settings);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Pengaturan berhasil disimpan'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal menyimpan pengaturan'
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

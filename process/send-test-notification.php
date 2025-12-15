<?php
session_start();
header('Content-Type: application/json');

require_once '../app/services/NotificationService.php';
require_once '../app/model/User.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $type = $input['type'] ?? 'test';
    
    // Get user info
    $userModel = new User();
    $user = $userModel->getUserById($userId);
    
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit;
    }
    
    $notificationService = new NotificationService();
    
    switch ($type) {
        case 'test':
            $result = $notificationService->sendNotification(
                $userId,
                $user['email'],
                $user['name'],
                'Test Notification 🔔',
                'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!',
                '/views/dashboard.php'
            );
            
            echo json_encode($result);
            break;
            
        case 'reminder':
            $mealType = $input['meal_type'] ?? 'breakfast';
            
            $result = $notificationService->sendMealReminder(
                $userId,
                $user['email'],
                $user['name'],
                $mealType
            );
            
            echo json_encode($result);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid notification type']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

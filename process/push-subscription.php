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
    $input = json_decode(file_get_contents('php://input'), true);
    
    $action = $input['action'] ?? '';
    
    $notificationModel = new Notification();
    
    switch ($action) {
        case 'subscribe':
            $endpoint = $input['endpoint'] ?? '';
            $p256dh = $input['keys']['p256dh'] ?? '';
            $auth = $input['keys']['auth'] ?? '';
            
            if (empty($endpoint) || empty($p256dh) || empty($auth)) {
                echo json_encode(['success' => false, 'message' => 'Invalid subscription data']);
                exit;
            }
            
            $result = $notificationModel->savePushSubscription($userId, $endpoint, $p256dh, $auth);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Push subscription saved successfully'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to save subscription'
                ]);
            }
            break;
            
        case 'unsubscribe':
            $endpoint = $input['endpoint'] ?? '';
            
            if (empty($endpoint)) {
                echo json_encode(['success' => false, 'message' => 'Invalid endpoint']);
                exit;
            }
            
            $result = $notificationModel->deleteSubscription($userId, $endpoint);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Push subscription removed successfully'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to remove subscription'
                ]);
            }
            break;
            
        case 'get_subscriptions':
            $subscriptions = $notificationModel->getUserSubscriptions($userId);
            echo json_encode([
                'success' => true,
                'subscriptions' => $subscriptions
            ]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

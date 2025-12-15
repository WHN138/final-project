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

if (!$input || !isset($input['subscription'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid subscription data']);
    exit;
}

$subscription = $input['subscription'];
$userId = $_SESSION['user_id'];

// Validate subscription data
if (!isset($subscription['endpoint']) || !isset($subscription['keys']['p256dh']) || !isset($subscription['keys']['auth'])) {
    echo json_encode(['success' => false, 'message' => 'Missing subscription keys']);
    exit;
}

try {
    $db = getDBConnection();
    $notification = new Notification($db);
    
    // Save subscription
    $result = $notification->saveSubscription(
        $userId,
        $subscription['endpoint'],
        $subscription['keys']['p256dh'],
        $subscription['keys']['auth']
    );
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Subscription saved successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to save subscription'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

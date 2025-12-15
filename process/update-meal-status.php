<?php
session_start();
require_once '../app/model/MealLog.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $logId = $data['log_id'] ?? null;
    $status = $data['status'] ?? null; // 'eaten' or 'planned'
    $userId = $_SESSION['user_id'];

    if (!$logId || !$status) {
        echo json_encode(['success' => false, 'message' => 'Invalid Data']);
        exit;
    }

    $mealLog = new MealLog();
    if ($mealLog->updateStatus($logId, $userId, $status)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengupdate status']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request']);
}

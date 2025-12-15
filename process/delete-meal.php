<?php
session_start();
require_once '../app/model/MealLog.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Anda harus login terlebih dahulu.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle both JSON and FormData
    $logId = $_POST['log_id'] ?? null;
    
    if (!$logId) {
        // Try JSON if FormData is empty
        $data = json_decode(file_get_contents('php://input'), true);
        $logId = $data['log_id'] ?? null;
    }
    
    $userId = $_SESSION['user_id'];

    if (!$logId) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
        exit;
    }

    $mealLog = new MealLog();
    if ($mealLog->deleteLog($logId, $userId)) {
        echo json_encode(['success' => true, 'message' => 'Makanan berhasil dihapus!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus data']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid']);
}
?>

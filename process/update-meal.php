<?php
session_start();
require_once '../app/model/MealLog.php';

// Set header for JSON response
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Anda harus login terlebih dahulu.'
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $logId = $_POST['log_id'] ?? '';
    $tanggal = $_POST['date'] ?? '';
    $waktuMakan = $_POST['meal_time'] ?? '';
    $foodName = trim($_POST['food_name'] ?? '');
    $calories = floatval($_POST['calories'] ?? 0);
    $protein = floatval($_POST['protein'] ?? 0);
    $fat = floatval($_POST['fat'] ?? 0);
    $carbs = floatval($_POST['carbs'] ?? 0);

    if (empty($logId) || empty($foodName) || empty($waktuMakan)) {
        echo json_encode([
            'success' => false,
            'message' => 'Data tidak lengkap!'
        ]);
        exit;
    }

    $mealLog = new MealLog();
    
    if ($mealLog->updateLog($logId, $userId, $waktuMakan, $tanggal, $foodName, $calories, $protein, $fat, $carbs)) {
        echo json_encode([
            'success' => true,
            'message' => 'Data makanan berhasil diupdate!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal mengupdate data. Silakan coba lagi.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Metode request tidak valid.'
    ]);
}
?>

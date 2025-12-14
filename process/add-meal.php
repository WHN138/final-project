<?php
session_start();
require_once '../app/model/MealLog.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/auth-login.php");
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['date'];
    $waktuMakan = $_POST['meal_time'];
    $foodName = trim($_POST['food_name']);
    $calories = floatval($_POST['calories']);
    $protein = floatval($_POST['protein']);
    $fat = floatval($_POST['fat']);
    $carbs = floatval($_POST['carbs']);
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    if (empty($foodName) || empty($waktuMakan)) {
        // Simple error handling
        echo "<script>alert('Nama makanan dan waktu makan wajib diisi!'); window.history.back();</script>";
        exit;
    }

    $mealLog = new MealLog();
    // Assuming addManualLog signature: ($userId, $waktuMakan, $tanggal, $foodName, $calories, $protein, $fat, $carbs, $porsi)
    // We treat porsi as 1 for manual entry or we could add a field for it.
    
    if ($mealLog->addManualLog($userId, $waktuMakan, $tanggal, $foodName, $calories, $protein, $fat, $carbs, 1)) {
        $_SESSION['notification'] = [
            'type' => 'success',
            'message' => 'Data makanan berhasil disimpan!'
        ];
        header("Location: ../views/log-harian.php");
        exit;
    } else {
        $_SESSION['notification'] = [
            'type' => 'error',
            'message' => 'Gagal menyimpan data.'
        ];
        header("Location: ../views/log-harian.php");
        exit;
    }
}
?>

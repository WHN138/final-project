<?php
class MealLog
{
    private $db;

    public function __construct()
    {
        if (!class_exists('Database')) {
            include "../app/config/database.php";
        }
        $this->db = (new Database())->connect();
    }

    public function addManualLog($userId, $waktuMakan, $tanggal, $foodName, $calories, $protein, $fat, $carbs, $porsi = 1)
    {
        // Note: Assuming table has these columns. If not, user needs to run ALTER TABLE.
        $stmt = $this->db->prepare("INSERT INTO meal_logs (user_id, waktu_makan, tanggal, food_name, calories, protein, fat, carbs, porsi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$userId, $waktuMakan, $tanggal, $foodName, $calories, $protein, $fat, $carbs, $porsi])) {
            return true;
        }
        return false;
    }

    public function getDailyLogs($userId, $date)
    {
        // Modified query to handle both manual entries (food_id IS NULL) and linked entries
        // If food_id is present, we join. If not, we take direct values.
        // Using LEFT JOIN to allow null food_id
        $query = "SELECT ml.id as log_id, ml.waktu_makan, ml.porsi, 
                         ml.food_name as name, 
                         ml.calories,   
                         ml.protein, 
                         ml.fat, 
                         ml.carbs,
                         ml.status
                  FROM meal_logs ml
                  WHERE ml.user_id = ? AND ml.tanggal = ?
                  ORDER BY ml.waktu_makan ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId, $date]);
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Group by meal time
        $grouped = [
            'pagi' => [],
            'siang' => [],
            'malam' => [],
            'cemilan' => [] // Changed 'snack' to 'cemilan' to match select option in View
        ];

        foreach ($logs as $log) {
            $waktu = strtolower($log['waktu_makan']);

            // Map common terms if needed, otherwise rely on exact match
            if ($waktu == 'snack') $waktu = 'cemilan';

            if (isset($grouped[$waktu])) {
                $grouped[$waktu][] = $log;
            } else {
                $grouped['cemilan'][] = $log;
            }
        }

        return $grouped;
    }

    public function deleteLog($logId, $userId)
    {
        // Pastikan hanya pemilik yang bisa hapus
        $stmt = $this->db->prepare("DELETE FROM meal_logs WHERE id=? AND user_id=?");
        if ($stmt->execute([$logId, $userId])) {
            return true;
        }
        return false;
    }

    public function updateStatus($logId, $userId, $status)
    {
        $stmt = $this->db->prepare("UPDATE meal_logs SET status = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$status, $logId, $userId]);
    }

    public function updateLog($logId, $userId, $waktuMakan, $tanggal, $foodName, $calories, $protein, $fat, $carbs)
    {
        $stmt = $this->db->prepare("UPDATE meal_logs SET waktu_makan = ?, tanggal = ?, food_name = ?, calories = ?, protein = ?, fat = ?, carbs = ? WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$waktuMakan, $tanggal, $foodName, $calories, $protein, $fat, $carbs, $logId, $userId])) {
            return true;
        }
        return false;
    }
}

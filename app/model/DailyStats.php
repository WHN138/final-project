<?php
class DailyStats
{
    private $db;

    public function __construct()
    {
        if (!class_exists('Database')) {
            include "app/config/database.php";
        }
        $this->db = (new Database())->connect();
    }

    public function getSummary($userId, $date)
    {
        $sql = "SELECT 
                    SUM(f.kalori * ml.porsi) as total_kalori,
                    SUM(f.protein * ml.porsi) as total_protein,
                    SUM(f.karbo * ml.porsi) as total_karbo,
                    SUM(f.lemak * ml.porsi) as total_lemak
                FROM meal_logs ml
                JOIN foods f ON ml.food_id = f.id
                WHERE ml.user_id = ? AND ml.tanggal = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $date]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getWeeklyHistory($userId)
    {
        // Ambil data 7 hari terakhir
        $sql = "SELECT 
                    ml.tanggal,
                    SUM(f.kalori * ml.porsi) as total_kalori
                FROM meal_logs ml
                JOIN foods f ON ml.food_id = f.id
                WHERE ml.user_id = ? 
                AND ml.tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                GROUP BY ml.tanggal
                ORDER BY ml.tanggal ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMonthlyHistory($userId, $month, $year)
    {
        $sql = "SELECT 
                    ml.tanggal,
                    SUM(f.kalori * ml.porsi) as total_kalori
                FROM meal_logs ml
                JOIN foods f ON ml.food_id = f.id
                WHERE ml.user_id = ? 
                AND MONTH(ml.tanggal) = ?
                AND YEAR(ml.tanggal) = ?
                GROUP BY ml.tanggal
                ORDER BY ml.tanggal ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $month, $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

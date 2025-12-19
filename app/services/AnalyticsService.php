<?php
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/MealLog.php';

class AnalyticsService {
    private $userModel;
    private $mealLogModel;

    public function __construct() {
        $this->userModel = new User();
        $this->mealLogModel = new MealLog();
    }

    public function getAnalyticsData($userId) {
        $tdee = $this->userModel->calculateTDEE($userId);
        
        // Weekly Stats for Chart
        $weeklyStats = $this->mealLogModel->getWeeklyStats($userId);
        
        // Prepare data for Chart
        $dates = [];
        $calories = [];
        $totalWeeklyCalories = 0;
        
        // Initialize last 7 days with 0
        $dataMap = [];
        foreach ($weeklyStats as $stat) {
            $dataMap[$stat['date']] = $stat['total_calories'];
        }

        for ($i = 6; $i >= 0; $i--) {
            $dateFull = date('Y-m-d', strtotime("-$i days"));
            $dayName = date('D', strtotime($dateFull));
            
            $dates[] = $dayName;
            $val = isset($dataMap[$dateFull]) ? (float)$dataMap[$dateFull] : 0;
            $calories[] = $val;
            $totalWeeklyCalories += $val;
        }

        // Avg based on 7 days or just active days? Usually 7 days if looking at weekly intake behavior.
        // But if we want avg of logged days: count($weeklyStats). 
        // Let's stick to average of logged days to be fairer, or average of 7 days if strict.
        // User request "Average Macros" - usually avg daily over a period.
        // If I log 1 day (2000) and 6 days (0), average 2000/7 = 285 is misleading if I just forgot to log.
        // But 2000/1 = 2000 is better representation of "when I eat, I eat this much".
        // However, "Weekly Average" often implies consistency. 
        // Let's use count($weeklyStats) for now to avoid dragging average down by missed logs.
        $avgCalories = count($weeklyStats) > 0 ? array_sum(array_column($weeklyStats, 'total_calories')) / count($weeklyStats) : 0;
        
        // Today Stats
        $todayCalories = $this->mealLogModel->getTodayCalories($userId);
        
        // Monthly Stats (for simple report if needed, or just relying on weekly for now)
        // $monthlyStats = $this->mealLogModel->getMonthlyStats($userId, date('m'), date('Y'));

        // Recommendation
        $recommendation = $this->generateRecommendation($todayCalories, $tdee);

        return [
            'tdee' => $tdee,
            'today_calories' => $todayCalories,
            'weekly_avg' => round($avgCalories),
            'chart_labels' => $dates,
            'chart_data' => $calories,
            'recommendation' => $recommendation
        ];
    }

    private function generateRecommendation($current, $target) {
        if ($target == 0) return "Lengkapi data profil (BB, TB, Usia) untuk mendapatkan target kalori.";
        
        $pct = ($current / $target) * 100;

        if ($pct < 50) {
            return "Asupan sangat rendah. Pastikan Anda makan cukup untuk energi tubuh.";
        } elseif ($pct < 90) {
            return "Sedikit lagi mencapai target! Coba tambahkan cemilan sehat.";
        } elseif ($pct <= 110) {
            return "Hebat! Asupan kalori Anda seimbang sesuai target.";
        } else {
            return "Asupan melebihi target. Pertimbangkan untuk mengurangi porsi makan malam atau olahraga ringan.";
        }
    }
    
    public function generateCSV($userId) {
        $weeklyStats = $this->mealLogModel->getWeeklyStats($userId);
        
        $filename = "laporan_mingguan_" . date('Y-m-d') . ".csv";
        
        // Clean buffer
        if (ob_get_level()) ob_end_clean();
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $output = fopen('php://output', 'w');
        
        // Header CSV
        fputcsv($output, ['Tanggal', 'Total Kalori (kkal)']);
        
        foreach ($weeklyStats as $row) {
            fputcsv($output, [$row['date'], $row['total_calories']]);
        }
        
        fclose($output);
        exit;
    }
}

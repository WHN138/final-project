<?php

class Absensi
{
    private $db;

    public function __construct()
    {
        if (file_exists(__DIR__ . '/../config/database.php')) {
            include_once __DIR__ . '/../config/database.php';
        }
        $this->db = (new Database())->connect();
    }

    public function clockIn($userId)
    {
        $date = date('Y-m-d');
        $time = date('H:i:s');

        // Check if already clocked in today
        if ($this->hasClockedIn($userId, $date)) {
            return "already_clocked_in";
        }

        $stmt = $this->db->prepare("INSERT INTO absensi (user_id, clock_in, date) VALUES (?, ?, ?)");
        if ($stmt->execute([$userId, $time, $date])) {
            return "success";
        }
        return "failed";
    }

    public function clockOut($userId)
    {
        $date = date('Y-m-d');
        $time = date('H:i:s');

        // Check if clocked in today
        if (!$this->hasClockedIn($userId, $date)) {
            return "not_clocked_in";
        }

        $stmt = $this->db->prepare("UPDATE absensi SET clock_out = ? WHERE user_id = ? AND date = ?");
        if ($stmt->execute([$time, $userId, $date])) {
            return "success";
        }
        return "failed";
    }

    public function getHistory($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM absensi WHERE user_id = ? ORDER BY date DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function hasClockedIn($userId, $date)
    {
        $stmt = $this->db->prepare("SELECT id FROM absensi WHERE user_id = ? AND date = ?");
        $stmt->execute([$userId, $date]);
        return $stmt->rowCount() > 0;
    }
}

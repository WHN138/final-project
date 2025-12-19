<?php
class User
{
    private $db;

    public function __construct()
    {
        // path otomatis aman
        if (!class_exists('Database')) {
            include __DIR__ . "/../config/database.php";
        }
        $this->db = (new Database())->connect();
    }

    public function login($email, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data && password_verify($password, $data['password'])) {
            $_SESSION['user'] = $data;
            return true;
        }
        return false;
    }

    public function register($username, $email, $password)
    {
        // cek email sudah terdaftar
        $check = $this->db->prepare("SELECT * FROM users WHERE email=?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            return "exists";
        }

        // hash password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // insert user
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

        if ($stmt->execute([$username, $email, $hash])) {
            return "success";
        }

        return "failed";
    }

    public function updateHealthData($id, $berat, $tinggi, $usia, $gender, $aktivitas)
    {
        $stmt = $this->db->prepare("UPDATE users SET berat_badan=?, tinggi_badan=?, usia=?, gender=?, level_aktivitas=? WHERE id=?");
        if ($stmt->execute([$berat, $tinggi, $usia, $gender, $aktivitas, $id])) {
            return true;
        }
        return false;
    }

    public function calculateTDEE($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) return 0;

        // Rumus Mifflin-St Jeor
        // Pria: (10 x weight) + (6.25 x height) - (5 x age) + 5
        // Wanita: (10 x weight) + (6.25 x height) - (5 x age) - 161

    //     $bmr = 0;
    //     if ($user['gender'] == 'L') {
    //         $bmr = (10 * $user['berat_badan']) + (6.25 * $user['tinggi_badan']) - (5 * $user['usia']) + 5;
    //     } else {
    //         $bmr = (10 * $user['berat_badan']) + (6.25 * $user['tinggi_badan']) - (5 * $user['usia']) - 161;
    //     }

    //     // Multiplier aktivitas
    //     $multipliers = [
    //         'sedentary' => 1.2,
    //         'light' => 1.375,
    //         'moderate' => 1.55,
    //         'active' => 1.725,
    //         'very_active' => 1.9
    //     ];

    //     $activity = $user['level_aktivitas'] ?? 'sedentary';
    //     $tdee = $bmr * ($multipliers[$activity] ?? 1.2);

    //     return round($tdee);
    // }
    // public function getUserById($id)
    // {
    //     $stmt = $this->db->prepare("SELECT * FROM users WHERE id=?");
    //     $stmt->execute([$id]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }
    }

    public function getRecentUsers($limit = 5)
    {
        $stmt = $this->db->prepare("SELECT * FROM users ORDER BY id DESC LIMIT ?");
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createAdmin($username, $email, $password, $nama)
    {
        // Check if email exists
        $check = $this->db->prepare("SELECT * FROM users WHERE email=?");
        $check->execute([$email]);
        if ($check->rowCount() > 0) {
            return "exists";
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $role = 'admin';

        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, nama, role) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$username, $email, $hash, $nama, $role])) {
            return "success";
        }
        return "failed";
    }

    public function getAllUsersCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM users");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getAllUsers()
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $username, $nama, $email, $role)
    {
        $stmt = $this->db->prepare("UPDATE users SET username=?, nama=?, email=?, role=? WHERE id=?");
        return $stmt->execute([$username, $nama, $email, $role, $id]);
    }

    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id=?");
        return $stmt->execute([$id]);
    }
}

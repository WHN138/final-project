<?php
class User
{
    private $db;

    public function __construct()
    {
        // path otomatis aman
        include "app/config/database.php";
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

    public function register($nama, $email, $password)
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
        $stmt = $this->db->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");

        if ($stmt->execute([$nama, $email, $hash])) {
            return "success";
        }

        return "failed";
    }
}

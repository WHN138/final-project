<?php
session_start();
require_once 'koneksi.php'; // file koneksi database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Cek input kosong
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email dan Password wajib diisi!";
        header("Location: login.php");
        exit;
    }

    try {
        // Cek email di database
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Jika email tidak ditemukan
        if ($stmt->rowCount() === 0) {
            $_SESSION['error'] = "Akun tidak ditemukan!";
            header("Location: login.php");
            exit;
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Password salah!";
            header("Location: login.php");
            exit;
        }

        // Jika berhasil login
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];

        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        die("ERROR: " . $e->getMessage());
    }
} else {
    header("Location: login.php");
    exit;
}

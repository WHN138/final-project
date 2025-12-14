<?php
session_start();
require_once '../app/model/User.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Cek input kosong
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email dan Password wajib diisi!";
        header("Location: ../views/auth-login.php");
        exit;
    }

    if ($user->login($email, $password)) {
        // $_SESSION['user'] is set inside $user->login() mechanism if needed, 
        // but looking at User.php:20, it sets $_SESSION['user'].
        // However, existing login-proses set individual session vars.
        // Let's rely on what User.php does (it specifically sets $_SESSION['user']).
        // But dashboard might expect individual keys. Let's check dashboard later or be safe.
        // The original login-proses set: login, user_id, nama.
        // User.php sets: user (array).
        
        // Let's add the specific session keys for compatibility
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $_SESSION['user']['id'];
        $_SESSION['nama'] = $_SESSION['user']['nama'];
        
        // Set success alert
        $_SESSION['alert'] = [
            'icon' => 'success',
            'title' => 'Login Berhasil',
            'text' => 'Selamat datang kembali di Dashboard!'
        ];

        header("Location: ../views/dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Email atau Password salah!";
        header("Location: ../views/auth-login.php");
        exit;
    }
} else {
    header("Location: ../views/auth-login.php");
    exit;
}

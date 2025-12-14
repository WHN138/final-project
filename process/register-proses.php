<?php
session_start();
require_once '../app/model/User.php';

$user = new User();

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$result = $user->register($username, $email, $password);

if ($result === "success") {
    $_SESSION['success'] = "Registrasi berhasil! Silahkan login.";
    header("Location: ../auth-login.php");
    exit;
} else if ($result === "exists") {
    $_SESSION['error'] = "Email sudah terdaftar!";
    header("Location: ../register.php");
    exit;
} else {
    $_SESSION['error'] = "Terjadi kesalahan. Coba ulangi.";
    header("Location: ../register.php");
    exit;
}

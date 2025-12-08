<?php
session_start();
require_once 'app/model/User.php';

$user = new User();

$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];

$result = $user->register($nama, $email, $password);

if ($result === "success") {
    $_SESSION['success'] = "Registrasi berhasil! Silahkan login.";
    header("Location: ../login.php");
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

<?php
session_start();
require_once "config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    $_SESSION['pesan_error'] = "Username dan password wajib diisi.";
    header("Location: login.php");
    exit;
}

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id_pengguna, username, password, nama_lengkap, level, status
     FROM tb_pengguna
     WHERE username = ?
     LIMIT 1"
);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['pesan_error'] = "Username atau password salah.";
    header("Location: login.php");
    exit;
}

if (strtolower($user['status']) !== 'aktif') {
    $_SESSION['pesan_error'] = "Akun tidak aktif.";
    header("Location: login.php");
    exit;
}

session_regenerate_id(true);

$_SESSION['id_pengguna'] = $user['id_pengguna'];
$_SESSION['username'] = $user['username'];
$_SESSION['nama_lengkap'] = $user['nama_lengkap'];
$_SESSION['level'] = $user['level'];

header("Location: dashboard.php");
exit;
?>

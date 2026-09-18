<?php
session_start();
if(isset($_SESSION['id_pengguna'])){header("Location: dashboard.php");exit;}
include "config/koneksi.php";
$error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
  $username=trim($_POST['username']??''); $password=$_POST['password']??'';
  $stmt=mysqli_prepare($koneksi,"SELECT * FROM tb_pengguna WHERE username=? AND status='Aktif' LIMIT 1");
  mysqli_stmt_bind_param($stmt,"s",$username); mysqli_stmt_execute($stmt);
  $r=mysqli_stmt_get_result($stmt); $u=mysqli_fetch_assoc($r);
  if($u && password_verify($password,$u['password'])){
    $_SESSION['id_pengguna']=$u['id_pengguna']; $_SESSION['nama_lengkap']=$u['nama_lengkap']; $_SESSION['level']=$u['level'];
    header("Location: dashboard.php");exit;
  } $error="Username atau password salah.";
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login - Kasir Nucky</title><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="login-page"><div class="login-box"><div class="login-brand"><div class="logo">🛒</div><h1>Kasir Nucky</h1><p>Sistem Informasi Penjualan & Stok</p></div><?php if($error):?><div class="alert"><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="post"><div class="form-group"><label>Username</label><input class="form-control" name="username" required></div><div class="form-group"><label>Password</label><input class="form-control" type="password" name="password" required></div><button class="btn">Masuk ke Sistem</button></form><div class="login-note">Silakan masuk menggunakan akun yang terdaftar.</div></div></body></html>
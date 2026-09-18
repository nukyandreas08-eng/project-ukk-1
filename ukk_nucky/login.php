<?php
session_start();

if (isset($_SESSION['id_pengguna'])) {
    header("Location: dashboard.php");
    exit;
}

$pesan = $_SESSION['pesan_error'] ?? '';
unset($_SESSION['pesan_error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPES</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        <div class="brand">
            <div class="logo">S</div>
            <h1>SIPES</h1>
            <p>Sistem Informasi Penjualan & Stok</p>
        </div>

        <?php if ($pesan): ?>
            <div class="alert"><?= htmlspecialchars($pesan) ?></div>
        <?php endif; ?>

        <form action="proses_login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                   placeholder="Masukkan username" required autofocus>

            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   placeholder="Masukkan password" required>

            <button type="submit">Login</button>
        </form>

        <small>Silakan masuk sesuai hak akses pengguna.</small>
    </div>
</div>
</body>
</html>

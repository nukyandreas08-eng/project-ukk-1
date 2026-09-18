<?php
session_start();

if (!isset($_SESSION['id_pengguna'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIPES</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
<div class="dashboard">
    <div class="topbar">
        <div>
            <h2>SIPES</h2>
            <span>Sistem Informasi Penjualan & Stok</span>
        </div>
        <a class="logout" href="logout.php">Logout</a>
    </div>

    <div class="welcome">
        <h1>Selamat datang, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>!</h1>
        <p>Level: <strong><?= htmlspecialchars($_SESSION['level']) ?></strong></p>
    </div>

    <div class="menu-grid">
        <div class="menu-card"><h3>Data Barang</h3><p>Kelola barang dan stok.</p></div>
        <div class="menu-card"><h3>Data Pelanggan</h3><p>Kelola data pelanggan.</p></div>
        <div class="menu-card"><h3>Transaksi</h3><p>Catat transaksi penjualan.</p></div>
        <div class="menu-card"><h3>Riwayat Transaksi</h3><p>Lihat transaksi yang telah dilakukan.</p></div>
    </div>
</div>
</body>
</html>

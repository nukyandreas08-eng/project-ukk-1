<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = $title ?? 'Kasir Nucky';
$projectRoot = str_replace('\\', '/', dirname(__DIR__));
$documentRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? '');
$base = str_replace($documentRoot, '', $projectRoot);
$base = '/' . trim($base, '/');
if ($base === '/') $base = '';
$current = basename($_SERVER['PHP_SELF'] ?? '');
$level = $_SESSION['level'] ?? '';
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($title) ?> - Kasir Nucky</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= $base ?>/assets/css/style.css">
</head>
<body>
<div class="layout">
<aside class="sidebar">
  <div class="brand"><span class="brand-icon">🛒</span><div><strong>Kasir Nucky</strong><small>Sistem Penjualan & Stok</small></div></div>
  <nav>
    <div class="nav-title">MENU UTAMA</div>
    <a class="nav-link" href="<?= $base ?>/dashboard.php"><span>🏠</span> Dashboard</a>

    <div class="nav-title">MASTER DATA</div>
    <?php if (in_array($level, ['Administrator','Petugas'], true)): ?>
      <a class="nav-link" href="<?= $base ?>/barang/index.php"><span>📦</span> Data Barang</a>
    <?php endif; ?>
    <?php if ($level === 'Administrator'): ?>
      <a class="nav-link" href="<?= $base ?>/pelanggan/index.php"><span>👥</span> Data Pelanggan</a>
      <a class="nav-link" href="<?= $base ?>/pengguna/index.php"><span>👤</span> Data Pengguna</a>
    <?php endif; ?>

    <div class="nav-title">TRANSAKSI</div>
    <?php if (in_array($level, ['Administrator','Petugas'], true)): ?>
      <a class="nav-link" href="<?= $base ?>/transaksi/index.php"><span>🛍️</span> Transaksi Penjualan</a>
    <?php endif; ?>
    <a class="nav-link" href="<?= $base ?>/riwayat/index.php"><span>🕘</span> Riwayat Transaksi</a>

    <div class="nav-title">LAPORAN</div>
    <a class="nav-link" href="<?= $base ?>/laporan/index.php"><span>📊</span> Laporan Penjualan</a>

    <div class="nav-title">AKUN</div>
    <a class="nav-link logout" href="<?= $base ?>/logout.php"><span>↪</span> Keluar</a>
  </nav>
  <div class="sidebar-footer"><strong>Kasir Nucky</strong><span>Versi 2.0</span></div>
</aside>
<main class="main">
<header class="topbar">
  <div class="topbar-title"><span class="menu-dot"></span><?= htmlspecialchars($title) ?></div>
  <div class="user"><div class="avatar">👤</div><div><strong><?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'User') ?></strong><span><?= htmlspecialchars($level) ?></span></div></div>
</header>
<div class="content">

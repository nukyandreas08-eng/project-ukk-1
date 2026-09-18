<?php
require_once "config/koneksi.php";

$akun = [
    ['admin', 'admin123', 'Administrator', 'Administrator'],
    ['petugas', 'petugas123', 'Petugas Penjualan', 'Petugas'],
    ['manajer', 'manajer123', 'Pemilik / Manajer', 'Pemilik/Manajer']
];

foreach ($akun as $a) {
    [$username, $password, $nama, $level] = $a;
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO tb_pengguna
        (username, password, nama_lengkap, level, status)
        VALUES (?, ?, ?, ?, 'Aktif')
        ON DUPLICATE KEY UPDATE
        password = VALUES(password),
        nama_lengkap = VALUES(nama_lengkap),
        level = VALUES(level),
        status = 'Aktif'"
    );

    mysqli_stmt_bind_param($stmt, "ssss", $username, $hash, $nama, $level);
    mysqli_stmt_execute($stmt);
}

echo "<h2>Akun berhasil dibuat.</h2>";
echo "<p>Admin: <b>admin</b> / <b>admin123</b></p>";
echo "<p>Petugas: <b>petugas</b> / <b>petugas123</b></p>";
echo "<p>Manajer: <b>manajer</b> / <b>manajer123</b></p>";
echo "<p><a href='login.php'>Ke halaman login</a></p>";
echo "<p>Setelah selesai, hapus file buat_user.php dari server lokal.</p>";
?>

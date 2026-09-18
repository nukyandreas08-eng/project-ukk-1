CREATE DATABASE IF NOT EXISTS db_sipes;
USE db_sipes;

CREATE TABLE IF NOT EXISTS tb_pengguna (
    id_pengguna INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    level VARCHAR(30) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Password untuk akun contoh dibuat dari password_hash PHP.
-- Ganti/isi akun melalui buat_user.php setelah project dijalankan.

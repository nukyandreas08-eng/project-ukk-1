CREATE DATABASE IF NOT EXISTS db_sipes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_sipes;

DROP TABLE IF EXISTS tb_detail_transaksi;
DROP TABLE IF EXISTS tb_transaksi;
DROP TABLE IF EXISTS tb_pelanggan;
DROP TABLE IF EXISTS tb_barang;
DROP TABLE IF EXISTS tb_pengguna;

CREATE TABLE tb_pengguna (
 id_pengguna INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(50) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 nama_lengkap VARCHAR(100) NOT NULL,
 level VARCHAR(30) NOT NULL,
 status VARCHAR(20) NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB;

CREATE TABLE tb_barang (
 id_barang INT AUTO_INCREMENT PRIMARY KEY,
 kode_barang VARCHAR(20) NOT NULL UNIQUE,
 nama_barang VARCHAR(100) NOT NULL,
 harga DECIMAL(12,2) NOT NULL DEFAULT 0,
 stok INT NOT NULL DEFAULT 0,
 satuan VARCHAR(30) NOT NULL,
 status VARCHAR(20) NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB;

CREATE TABLE tb_pelanggan (
 id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
 nama_pelanggan VARCHAR(100) NOT NULL,
 no_hp VARCHAR(25),
 alamat TEXT
) ENGINE=InnoDB;

CREATE TABLE tb_transaksi (
 id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
 no_transaksi VARCHAR(40) NOT NULL UNIQUE,
 tanggal DATETIME NOT NULL,
 id_pengguna INT NOT NULL,
 id_pelanggan INT NULL,
 total_bayar DECIMAL(12,2) NOT NULL DEFAULT 0,
 CONSTRAINT fk_transaksi_pengguna FOREIGN KEY(id_pengguna) REFERENCES tb_pengguna(id_pengguna),
 CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY(id_pelanggan) REFERENCES tb_pelanggan(id_pelanggan) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE tb_detail_transaksi (
 id_detail INT AUTO_INCREMENT PRIMARY KEY,
 id_transaksi INT NOT NULL,
 id_barang INT NOT NULL,
 jumlah INT NOT NULL,
 harga DECIMAL(12,2) NOT NULL,
 subtotal DECIMAL(12,2) NOT NULL,
 CONSTRAINT fk_detail_transaksi FOREIGN KEY(id_transaksi) REFERENCES tb_transaksi(id_transaksi) ON DELETE CASCADE,
 CONSTRAINT fk_detail_barang FOREIGN KEY(id_barang) REFERENCES tb_barang(id_barang)
) ENGINE=InnoDB;

INSERT INTO tb_pengguna (username,password,nama_lengkap,level,status) VALUES
('admin', '$2y$12$QfDo5JGtck2qLJxdFsyc1uNPwVLle/.dOlXCklmc/X3r7vLYAmUGy', 'Administrator', 'Administrator', 'Aktif'),
('petugas', '$2y$12$Q7MlYGPeVq2fIvlw1hyAouiXm9BRVS20Q77mUkNrWVgYB7/NIkb5K', 'Petugas', 'Petugas', 'Aktif'),
('pemilik', '$2y$12$2E47lByrX.Zbfsq9W7qyEub8UoF.ZQjouPJztQ6p2vn6Fc2dA9StG', 'Pemilik / Manajer', 'Pemilik/Manajer', 'Aktif');

INSERT INTO tb_barang (kode_barang,nama_barang,harga,stok,satuan,status) VALUES
('BRG001','Beras 5 Kg',75000,20,'pcs','Aktif'),
('BRG002','Minyak Goreng 1 Liter',18000,30,'botol','Aktif'),
('BRG003','Gula Pasir 1 Kg',17000,25,'kg','Aktif'),
('BRG004','Tepung Terigu 1 Kg',14000,25,'kg','Aktif'),
('BRG005','Telur Ayam 1 Kg',30000,15,'kg','Aktif'),
('BRG006','Mie Instan Goreng',3500,50,'pcs','Aktif'),
('BRG007','Kopi Sachet',2500,40,'pcs','Aktif'),
('BRG008','Teh Celup',12000,20,'kotak','Aktif'),
('BRG009','Air Mineral 600 ml',4000,48,'botol','Aktif'),
('BRG010','Susu UHT 1 Liter',22000,18,'kotak','Aktif');

INSERT INTO tb_pelanggan(nama_pelanggan,no_hp,alamat) VALUES
('Pelanggan Umum','-','-'),
('Andi','081234567890','Tasikmalaya'),
('Siti','082345678901','Tasikmalaya');

-- Login awal: admin / admin123, petugas / petugas123, pemilik / pemilik123

KASIR NUCKY - SISTEM PENJUALAN & STOK
======================================

Versi: 2.0

FITUR
-----
- Login dengan role Administrator, Petugas, dan Pemilik/Manajer
- Dashboard modern dengan statistik penjualan, transaksi terbaru, dan stok menipis
- Data Barang: tambah, edit, hapus, pencarian, dan status barang
- Data Pelanggan
- Data Pengguna
- Transaksi penjualan dengan keranjang
- Pilihan pelanggan atau Pelanggan Umum
- Stok otomatis berkurang saat transaksi disimpan
- Riwayat dan detail transaksi
- Cetak struk transaksi
- Laporan penjualan berdasarkan tanggal
- Tampilan responsif untuk laptop dan HP

CARA INSTALL DI XAMPP
---------------------
1. Ekstrak folder Kasir_Nucky ke C:\xampp\htdocs\
2. Jalankan Apache dan MySQL dari XAMPP.
3. Buka http://localhost/phpmyadmin/
4. Buat database bernama db_sipes (atau gunakan database sesuai isi database.sql).
5. Import file database.sql.
6. Buka http://localhost/Kasir_Nucky/login.php

AKUN LOGIN
----------
Administrator : admin / admin123
Petugas       : petugas / petugas123
Pemilik       : pemilik / pemilik123

CATATAN
-------
- Password sudah menggunakan password_hash PHP.
- Jika nama folder berbeda, aplikasi tetap mencoba menentukan alamat root secara otomatis untuk menu dan CSS.
- Pastikan database pada config/koneksi.php sesuai dengan database yang dibuat.

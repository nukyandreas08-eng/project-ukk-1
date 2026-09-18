<?php
include "../includes/cek_session.php";
include "../config/koneksi.php";
hanya_role('Administrator','Petugas');
if(empty($_SESSION['keranjang'])){header("Location:index.php");exit;}
$id_pelanggan=!empty($_POST['id_pelanggan'])?(int)$_POST['id_pelanggan']:0;
$total=0;foreach($_SESSION['keranjang'] as $id=>$it)$total += $it['harga']*$it['jumlah'];
mysqli_begin_transaction($koneksi);
try{
 $no='TRX-'.date('YmdHis').'-'.rand(100,999);$tanggal=date('Y-m-d H:i:s');$kasir=(int)$_SESSION['id_pengguna'];
 if($id_pelanggan>0){
   $st=mysqli_prepare($koneksi,"INSERT INTO tb_transaksi(no_transaksi,tanggal,id_pengguna,id_pelanggan,total_bayar) VALUES(?,?,?,?,?)");
   mysqli_stmt_bind_param($st,"ssiid",$no,$tanggal,$kasir,$id_pelanggan,$total);
 }else{
   $st=mysqli_prepare($koneksi,"INSERT INTO tb_transaksi(no_transaksi,tanggal,id_pengguna,id_pelanggan,total_bayar) VALUES(?,?,?,NULL,?)");
   mysqli_stmt_bind_param($st,"ssid",$no,$tanggal,$kasir,$total);
 }
 if(!mysqli_stmt_execute($st)) throw new Exception(mysqli_stmt_error($st));
 $id_transaksi=mysqli_insert_id($koneksi);
 foreach($_SESSION['keranjang'] as $id=>$it){
   $id=(int)$id;$j=(int)$it['jumlah'];$harga=(float)$it['harga'];$sub=$harga*$j;
   $cek=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT stok FROM tb_barang WHERE id_barang=$id AND status='Aktif' FOR UPDATE"));
   if(!$cek || $cek['stok']<$j) throw new Exception("Stok tidak mencukupi untuk barang yang dipilih.");
   $d=mysqli_prepare($koneksi,"INSERT INTO tb_detail_transaksi(id_transaksi,id_barang,jumlah,harga,subtotal) VALUES(?,?,?,?,?)");
   mysqli_stmt_bind_param($d,"iiidd",$id_transaksi,$id,$j,$harga,$sub);
   if(!mysqli_stmt_execute($d)) throw new Exception(mysqli_stmt_error($d));
   mysqli_query($koneksi,"UPDATE tb_barang SET stok=stok-$j WHERE id_barang=$id");
 }
 mysqli_commit($koneksi);$_SESSION['keranjang']=[];header("Location:../riwayat/detail.php?id=$id_transaksi");exit;
}catch(Throwable $e){mysqli_rollback($koneksi);die("Transaksi gagal: ".htmlspecialchars($e->getMessage()));}
?>

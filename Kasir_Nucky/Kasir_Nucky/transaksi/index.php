<?php
include "../includes/cek_session.php";include "../config/koneksi.php";hanya_role('Administrator','Petugas');$title="Transaksi Penjualan";include "../includes/header.php";
if(!isset($_SESSION['keranjang']))$_SESSION['keranjang']=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
 $id=(int)($_POST['id_barang']??0);$jumlah=max(1,(int)($_POST['jumlah']??1));
 $r=mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tb_barang WHERE id_barang=$id AND status='Aktif' AND stok>0"));
 if($r && $jumlah <= $r['stok']){
   if(isset($_SESSION['keranjang'][$id])) $_SESSION['keranjang'][$id]['jumlah'] += $jumlah;
   else $_SESSION['keranjang'][$id]=['nama'=>$r['nama_barang'],'harga'=>$r['harga'],'jumlah'=>$jumlah];
 }
}
$total=0;foreach($_SESSION['keranjang'] as $it)$total += $it['harga']*$it['jumlah'];
$barang=mysqli_query($koneksi,"SELECT * FROM tb_barang WHERE status='Aktif' AND stok>0 ORDER BY nama_barang");
$pelanggan=mysqli_query($koneksi,"SELECT * FROM tb_pelanggan ORDER BY nama_pelanggan");
?>
<div class="page-head"><h1>Transaksi Penjualan</h1><a class="btn light" href="kosongkan.php">Kosongkan</a></div>
<div class="panel"><form method="post"><div class="form-grid"><div class="form-group"><label>Barang</label><select class="form-control" name="id_barang" required><option value="">-- Pilih Barang --</option><?php while($b=mysqli_fetch_assoc($barang)):?><option value="<?=$b['id_barang']?>"><?=htmlspecialchars($b['nama_barang'])?> - Rp <?=number_format($b['harga'],0,',','.')?> (stok <?=$b['stok']?>)</option><?php endwhile;?></select></div><div class="form-group"><label>Jumlah</label><input class="form-control" type="number" name="jumlah" min="1" value="1" required></div></div><br><button class="btn">+ Masukkan Keranjang</button></form></div>
<div class="panel"><h3>Keranjang</h3><div class="table-wrap"><table><tr><th>Barang</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th></th></tr><?php foreach($_SESSION['keranjang'] as $id=>$it):$sub=$it['harga']*$it['jumlah'];?><tr><td><?=htmlspecialchars($it['nama'])?></td><td>Rp <?=number_format($it['harga'],0,',','.')?></td><td><?=$it['jumlah']?></td><td>Rp <?=number_format($sub,0,',','.')?></td><td><a class="btn danger" href="hapus_item.php?id=<?=$id?>">Hapus</a></td></tr><?php endforeach;?></table></div><p class="text-right total">Total: Rp <?=number_format($total,0,',','.')?></p><?php if($total>0):?><form method="post" action="simpan.php"><div class="form-group"><label>Pelanggan</label><select class="form-control" name="id_pelanggan"><option value="">-- Pelanggan Umum --</option><?php while($p=mysqli_fetch_assoc($pelanggan)):?><option value="<?=$p['id_pelanggan']?>"><?=htmlspecialchars($p['nama_pelanggan'])?></option><?php endwhile;?></select></div><br><button class="btn success">Simpan Transaksi</button></form><?php endif;?></div>
<?php include "../includes/footer.php"; ?>
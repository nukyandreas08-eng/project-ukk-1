<?php
include "../includes/cek_session.php"; include "../config/koneksi.php"; hanya_role('Administrator','Petugas'); $title="Data Barang"; include "../includes/header.php";
$q=trim($_GET['q']??''); $safe=mysqli_real_escape_string($koneksi,$q);
$sql="SELECT * FROM tb_barang WHERE kode_barang LIKE '%$safe%' OR nama_barang LIKE '%$safe%' ORDER BY id_barang DESC";
$data=mysqli_query($koneksi,$sql);
?>
<div class="page-head"><h1>Data Barang</h1><?php if($_SESSION['level']==='Administrator'):?><a class="btn" href="tambah.php">+ Tambah Barang</a><?php endif;?></div>
<div class="panel"><form class="filter"><input class="form-control" name="q" placeholder="Cari kode / nama barang" value="<?=htmlspecialchars($q)?>"><button class="btn">Cari</button></form>
<div class="table-wrap"><table><tr><th>No</th><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Stok</th><th>Satuan</th><th>Status</th><?php if($_SESSION['level']==='Administrator'):?><th>Aksi</th><?php endif;?></tr>
<?php $no=1; while($b=mysqli_fetch_assoc($data)):?><tr><td><?=$no++?></td><td><?=htmlspecialchars($b['kode_barang'])?></td><td><?=htmlspecialchars($b['nama_barang'])?></td><td>Rp <?=number_format($b['harga'],0,',','.')?></td><td class="<?=($b['stok']<=5?'low':'')?>"><?=$b['stok']?></td><td><?=htmlspecialchars($b['satuan'])?></td><td><?=htmlspecialchars($b['status'])?></td><?php if($_SESSION['level']==='Administrator'):?><td class="actions"><a class="btn light" href="edit.php?id=<?=$b['id_barang']?>">Edit</a><a class="btn danger" data-confirm="Hapus barang ini?" href="hapus.php?id=<?=$b['id_barang']?>">Hapus</a></td><?php endif;?></tr><?php endwhile;?></table></div></div>
<?php include "../includes/footer.php"; ?>
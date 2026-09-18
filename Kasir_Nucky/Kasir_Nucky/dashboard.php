<?php
include "includes/cek_session.php";
include "config/koneksi.php";
$title="Dashboard";
include "includes/header.php";
function countq($db,$sql){$r=mysqli_query($db,$sql);return $r ? (mysqli_fetch_row($r)[0] ?? 0) : 0;}
$barang=(int)countq($koneksi,"SELECT COUNT(*) FROM tb_barang");
$pelanggan=(int)countq($koneksi,"SELECT COUNT(*) FROM tb_pelanggan");
$transaksi=(int)countq($koneksi,"SELECT COUNT(*) FROM tb_transaksi");
$omzet=(float)countq($koneksi,"SELECT COALESCE(SUM(total_bayar),0) FROM tb_transaksi");
$stok=(int)countq($koneksi,"SELECT COALESCE(SUM(stok),0) FROM tb_barang");
$stokRendah=(int)countq($koneksi,"SELECT COUNT(*) FROM tb_barang WHERE stok<=5 AND status='Aktif'");
$omzetHariIni=(float)countq($koneksi,"SELECT COALESCE(SUM(total_bayar),0) FROM tb_transaksi WHERE DATE(tanggal)=CURDATE()");
$transaksiHariIni=(int)countq($koneksi,"SELECT COUNT(*) FROM tb_transaksi WHERE DATE(tanggal)=CURDATE()");
$recent=mysqli_query($koneksi,"SELECT t.no_transaksi,t.tanggal,t.total_bayar,COALESCE(p.nama_pelanggan,'Pelanggan Umum') pelanggan FROM tb_transaksi t LEFT JOIN tb_pelanggan p ON p.id_pelanggan=t.id_pelanggan ORDER BY t.id_transaksi DESC LIMIT 5");
$low=mysqli_query($koneksi,"SELECT nama_barang,stok,satuan FROM tb_barang WHERE stok<=5 AND status='Aktif' ORDER BY stok ASC,nama_barang ASC LIMIT 5");
$daily=[]; $maxDaily=1;
for($i=6;$i>=0;$i--){$date=date('Y-m-d',strtotime("-$i days"));$q=mysqli_query($koneksi,"SELECT COALESCE(SUM(total_bayar),0) total FROM tb_transaksi WHERE DATE(tanggal)='$date'");$val=(float)(mysqli_fetch_assoc($q)['total']??0);$daily[]=['label'=>date('d/m',strtotime($date)),'value'=>$val];if($val>$maxDaily)$maxDaily=$val;}
?>
<div class="page-head"><div><h1>Dashboard</h1><div class="muted">Selamat datang, <?=htmlspecialchars($_SESSION['nama_lengkap'])?>. Kelola penjualan dan stok dengan mudah.</div></div><a class="btn" href="transaksi/index.php">+ Transaksi Baru</a></div>

<div class="cards">
 <div class="stat-card blue"><div class="stat-icon">📦</div><div class="label">Total Barang</div><div class="value"><?=$barang?></div><div class="sub">Data barang tersimpan</div></div>
 <div class="stat-card green"><div class="stat-icon">👥</div><div class="label">Total Pelanggan</div><div class="value"><?=$pelanggan?></div><div class="sub">Pelanggan terdaftar</div></div>
 <div class="stat-card orange"><div class="stat-icon">🛒</div><div class="label">Total Transaksi</div><div class="value"><?=$transaksi?></div><div class="sub">Seluruh transaksi</div></div>
 <div class="stat-card purple"><div class="stat-icon">💰</div><div class="label">Total Penjualan</div><div class="value">Rp <?=number_format($omzet,0,',','.')?></div><div class="sub">Akumulasi penjualan</div></div>
</div>

<div class="quick-grid">
 <a class="quick" href="transaksi/index.php"><div class="qicon">🛍️</div><div><strong>Transaksi Penjualan</strong><span>Mulai transaksi baru</span></div></a>
 <a class="quick" href="barang/index.php"><div class="qicon">📦</div><div><strong>Kelola Barang</strong><span>Tambah & cek stok</span></div></a>
 <a class="quick" href="riwayat/index.php"><div class="qicon">🕘</div><div><strong>Riwayat Transaksi</strong><span>Lihat transaksi</span></div></a>
 <a class="quick" href="laporan/index.php"><div class="qicon">📊</div><div><strong>Laporan Penjualan</strong><span>Cetak laporan</span></div></a>
</div>

<div class="dashboard-grid">
 <div class="panel"><div class="panel-head"><h3>📈 Penjualan 7 Hari Terakhir</h3><span class="badge">Rp</span></div><div class="mini-chart"><?php foreach($daily as $d):$height=max(8,round(($d['value']/$maxDaily)*100));?><div class="bar-col"><em><?=number_format($d['value']/1000,0,',','.')?>K</em><div class="bar" style="height:<?=$height?>%" title="Rp <?=number_format($d['value'],0,',','.')?>"></div><small><?=$d['label']?></small></div><?php endforeach;?></div></div>
 <div class="panel"><div class="panel-head"><h3>⚡ Ringkasan Hari Ini</h3></div><div class="summary-list"><div class="summary-item"><span>Penjualan hari ini</span><strong>Rp <?=number_format($omzetHariIni,0,',','.')?></strong></div><div class="summary-item"><span>Transaksi hari ini</span><strong><?=$transaksiHariIni?></strong></div><div class="summary-item"><span>Total stok barang</span><strong><?=$stok?> item</strong></div><div class="summary-item"><span>Stok perlu dicek</span><strong class="<?= $stokRendah>0?'low':'ok'?>"><?=$stokRendah?> barang</strong></div></div></div>
</div>

<div class="dashboard-grid">
 <div class="panel"><div class="panel-head"><h3>🧾 Transaksi Terbaru</h3><a class="btn light" href="riwayat/index.php">Lihat Semua</a></div><div class="table-wrap"><table><tr><th>No Transaksi</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th></tr><?php if($recent && mysqli_num_rows($recent)):while($r=mysqli_fetch_assoc($recent)):?><tr><td><strong><?=htmlspecialchars($r['no_transaksi'])?></strong></td><td><?=htmlspecialchars($r['tanggal'])?></td><td><?=htmlspecialchars($r['pelanggan'])?></td><td>Rp <?=number_format($r['total_bayar'],0,',','.')?></td></tr><?php endwhile;else:?><tr><td colspan="4" class="empty">Belum ada transaksi.</td></tr><?php endif;?></table></div></div>
 <div class="panel"><div class="panel-head"><h3>⚠️ Stok Menipis</h3><a class="btn light" href="barang/index.php">Lihat Barang</a></div><div class="table-wrap"><table><tr><th>Barang</th><th>Stok</th><th>Satuan</th></tr><?php if($low && mysqli_num_rows($low)):while($r=mysqli_fetch_assoc($low)):?><tr><td><?=htmlspecialchars($r['nama_barang'])?></td><td class="low"><?=$r['stok']?></td><td><?=htmlspecialchars($r['satuan'])?></td></tr><?php endwhile;else:?><tr><td colspan="3" class="empty">Semua stok masih aman.</td></tr><?php endif;?></table></div></div>
</div>
<?php include "includes/footer.php"; ?>

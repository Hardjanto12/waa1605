<?php
if(isset($_SESSION['SES_LOGIN'])){
	# JIKA SUDAH LOGIN, menu di bawah yang dijalankan
	$levelAkses = $_SESSION['SES_LEVEL'];
	
	if($levelAkses =="0001") {
		// MENU UNTUK ADMINISTRATOR
		?>


<li class="text-center text-white"><strong>Master</strong>
<li><a href="?open=Account-Data" target="_self"> Account </a></li>
<li><a href="?open=Supplier-Data" target="_self"> Supplier </a></li>
<li><a href="?open=Customer-Data" target="_self"> Customer </a></li>
<li><a href="?open=Mesin-Data" target="_self"> Mesin </a></li>
<li><a href="?open=Proyek-Data" target="_self"> Proyek </a></li>
<li><a href="?open=Dept-Data" target="_self"> Kategori </a></li>
<li><a href="?open=Inventory-Data" target="_self"> Inventory </a></li>
</li>
</li>
<li class="text-center text-white"><strong>Transaksi</strong>
<li><a href="?open=Pembelian-Data" target="_self"> Pembelian </a></li>
<li><a href="?open=Pemakaian-Data" target="_self"> Pemakaian Bahan </a></li>
<li><a href="?open=Pemakaian-Data2" target="_self"> Approval Pemakaian Bahan </a></li>
<li><a href="?open=Produksi-Data" target="_self"> Hasil Produksi </a></li>
<li><a href="?open=BiayaOverhead-Data" target="_self"> Biaya Overhead </a></li>
<li><a href="?open=Penjualan-Data" target="_self"> Penjualan </a></li>
</li>
<li class="text-center text-white"><strong>Laporan</strong>
<li><a href="?open=Laporan-Pembelian" target="_self"> Pembelian </a></li>
<li><a href="?open=Laporan-Pemakaian" target="_self"> Pemakaian Bahan </a></li>
<li><a href="?open=Laporan-Produksi" target="_self"> Hasil Produksi </a></li>
<li><a href="?open=Laporan-Overhead" target="_self"> Biaya Overhead </a></li>
<li><a href="?open=Laporan-Penjualan" target="_self"> Penjualan </a></li>
<li><a href="?open=Laporan-HPP" target="_self"> HPP Produksi </a></li>
<li><a href="?open=Laporan-Stock" target="_self"> Stock </a></li>
</li>

<li class="text-center"><strong>Tools</strong>
<li><a href="?open=Ubah-Password" target="_self"> Ganti Password </a></li>
<li><a href="?open=Logout" target="_self"> Logout </a></li>
</li>


<?php 
	}
	else if($levelAkses =="6") {
		// MENU UNTUK KEPALA PABRIK
		?>



<?php 
		
	
	}
	else if($levelAkses =="7") {
		// MENU UNTUK KEPALA DIREKSI
		?>


<?php 
		
	
	}
	else {
		// TIDAK ADA LEVEL
	}
}
else {
	# JIKA BELUM LOGIN (Tidak ada Session yang ditemukan)
?>
<ul>
    <li><a href="?open=Login" target="_self">Login</a> </li>
</ul>
<?php
}
?>
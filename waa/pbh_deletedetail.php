<?php
// Koneksi ke database MySQL
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php"; 

// Membaca variabel Kode pada URL (alamat browser)
if(isset($_GET['Kode'],$_GET['Seq'])){
	$Kode	= $_GET['Kode'];
	$Seq	= $_GET['Seq'];
	// Membaca data Gambar/ Foto
	
	// Hapus data sesuai Kode yang terbaca
	$my2Sql	= "delete FROM pbd WHERE nojnl='$Kode' and dtseq=$Seq";
	$my2Qry = sqlsrv_query($koneksidb, $my2Sql) ;
	if($my2Qry){
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Pemakaian-Add'>";
	}
		exit;
}
else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?> 



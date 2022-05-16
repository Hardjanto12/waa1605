<?php
// Koneksi ke database MySQL
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php"; 

// Membaca variabel Kode pada URL (alamat browser)
if(isset($_GET['Kode'])){
	$Kode	= $_GET['Kode'];
	
	// Membaca data Gambar/ Foto
	$mySql	= "SELECT kdac FROM acc WHERE kdac='$Kode'";
	$myQry	= sqlsrv_query($koneksidb, $mySql) ;
	$myData	= sqlsrv_fetch_array($myQry);
	
	// Hapus data sesuai Kode yang terbaca
	$my2Sql = "DELETE FROM acc WHERE kdac='$Kode'";
	$my2Qry = sqlsrv_query($koneksidb, $my2Sql) ;
	if($my2Qry){
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Account-Data'>";
	}
}
else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?> 



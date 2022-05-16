<?php
// Koneksi ke database MySQL
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php"; 

// Membaca variabel Kode pada URL (alamat browser)
if(isset($_GET['Kode'])){
	$Kode	= $_GET['Kode'];
	$userLogin	= $_SESSION['SES_LOGIN'];
	
	// Hapus data sesuai Kode yang terbaca
	$my2Sql = "update pbh set control='1', chuser2='$userLogin', chtime2=getdate() WHERE nojnl='$Kode'";
	echo $my2Sql;
	$my2Qry = sqlsrv_query($koneksidb, $my2Sql) ;
	if($my2Qry){
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Pemakaian-Data2'>";
	}
	exit;
}
else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?> 



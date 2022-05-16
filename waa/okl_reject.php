<?php
// Koneksi ke database MySQL
include_once "library/inc.seslogin.php"; 
include_once "library/inc.connection.php";
include_once "library/inc.library.php"; 

$userLogin	= $_SESSION['SES_LOGIN'];
// Membaca variabel Kode pada URL (alamat browser)
if(isset($_GET['Kode'])){
	$Kode	= $_GET['Kode'];
	$prd=substr($Kode,5,2) . substr($Kode,3,2);
	// Hapus data sesuai Kode yang terbaca
 	$mySql = "update okl set control='2', chtime1=getdate(), chuser1='$userLogin', chtime=getdate(), chuser='$userLogin' WHERE nojnl='$Kode'";
	$myQry = sqlsrv_query($koneksidb, $mySql) ;
	if( $myQry === false ) {
			 die( print_r( sqlsrv_errors(), true));
	}
 	$my2Sql = "update okl" . $prd . " set control='2', chtime1=getdate(), chuser1='$userLogin', chtime=getdate(), chuser='$userLogin' WHERE nojnl='$Kode'";
	$my2Qry = sqlsrv_query($koneksidb, $my2Sql) ;
	if( $my2Qry === false ) {
		// Refresh halaman
			 die( print_r( sqlsrv_errors(), true));
	}
		echo "<meta http-equiv='refresh' content='0; url=?open=OrderPenjualan-Data'>";
 	exit;
}
else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?> 



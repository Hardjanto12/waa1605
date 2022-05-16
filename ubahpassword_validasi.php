<?php 
# MEMMBACA TOMBOL LOGIN DARI FORM login.php
$userLogin	= $_SESSION['SES_LOGIN'];
if(isset($_POST['btnLogin'])){
	# Baca variabel form
//	$txtUser 	= $_POST['txtUser'];
//	$txtUser 	= str_replace("'","&acute;",$txtUser);

	$txtPassword1=$_POST['txtPassword1'];
	$txtPassword1= str_replace("'","&acute;",$txtPassword1);
	$txtPassword2=$_POST['txtPassword2'];
	$txtPassword2= str_replace("'","&acute;",$txtPassword2);
	$txtPassword3=$_POST['txtPassword3'];
	$txtPassword3= str_replace("'","&acute;",$txtPassword3);
//	echo $txtPassword1;	
	$cmbLevel	="Admin";
	
	// Validasi form
	$pesanError = array();
	if (trim($txtPassword1)=="") {
		$pesanError[] = "Data <b> Password Lama </b> tidak boleh kosong !";		
	}
	if (trim($txtPassword2)=="") {
		$pesanError[] = "Data <b> Password Baru </b> tidak boleh kosong !";		
	}
	if (trim($txtPassword3)=="") {
		$pesanError[] = "Data <b> Password Baru </b> tidak boleh kosong !";		
	}
	if (trim($txtPassword3)!==trim($txtPassword2)) {
		$pesanError[] = "Data <b> Password Baru harus Sama </b> !";		
	}
	$mySql	= "select * from muser where musername='$userLogin' and muserpass='" . md5($txtPassword1) . "'";
	$myQry = sqlsrv_query( $koneksidb, $mySql);
	$myData= sqlsrv_fetch_array($myQry);
	if($myData['muserName']=='') {
		$pesanError[] = "Password Lama Invalid !";		
	}
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
		
		// Tampilkan lagi form login
//		exit;
//		include "Halaman-Utama.php";
	}
	else {
		# LOGIN CEK KE TABEL USER LOGIN
		$mySql	= "update muser set muserpass='" . md5($txtPassword2) . "' where musername='$userLogin'";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?open=Halaman-Utama'>";
		exit;	
	}
} // End POST
?>
 

<?php 
# MEMMBACA TOMBOL LOGIN DARI FORM login.php
if(isset($_POST['btnLogin'])){
	# Baca variabel form
	$txtUser 	= $_POST['txtUser'];
	$txtUser 	= str_replace("'","&acute;",$txtUser);
	
	$txtPassword=$_POST['txtPassword'];
	$txtPassword= str_replace("'","&acute;",$txtPassword);
	
	$cmbLevel	="Admin";
	
	// Validasi form
	$pesanError = array();
	if ( trim($txtUser)=="") {
		$pesanError[] = "Data <b> Username </b>  tidak boleh kosong !";		
	}
	if (trim($txtPassword)=="") {
		$pesanError[] = "Data <b> Password </b> tidak boleh kosong !";		
	}
	if (trim($cmbLevel)=="Kosong") {
		$pesanError[] = "Data <b>Level</b> belum dipilih !";		
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
		include "login.php";
	}
	else {
		# LOGIN CEK KE TABEL USER LOGIN
		$mySql = "SELECT * FROM mUser WHERE muserName='" . $txtUser . "' AND muserpass='" . md5($txtPassword) . "'";
		$myQry = sqlsrv_query( $koneksidb, $mySql);
		$myData= sqlsrv_fetch_array($myQry);
		$rowcount=sqlsrv_num_rows($myQry);
		# JIKA LOGIN SUKSES
//		echo md5($txtPassword);
		if($myData['muserName']<>'') {
			$_SESSION['SES_LOGIN'] = $myData['muserName']; 
			$_SESSION['SES_LEVEL'] = $myData['mguserCode']; 
			
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Halaman-Utama'>";
		}
		else {
			 echo "Login Failed!";
		}
	}
} // End POST
?>
 

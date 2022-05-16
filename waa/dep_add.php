<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.seslogin.php"; 

$userLogin	= $_SESSION['SES_LOGIN'];

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Data dari Form Input
	$txtKode		= $_POST['txtKode'];
	$txtNama		= $_POST['txtNama'];
 
   # Validasi Form Input 
	// Validasi Form Input
	$pesanError = array();
	if (trim($txtKode)=="") {
		$pesanError[] = "Data <b>Kode </b> tidak boleh kosong !";		
	}
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama </b> tidak boleh kosong !";		
	}
	$mySql	= "select * from dep where dep='" . trim($txtKode) . "'";
	$myQry = sqlsrv_query( $koneksidb, $mySql);
	$myData= sqlsrv_fetch_array($myQry);
	if($myData['dep']<>'') {
		$pesanError[] = "Kode sudah ada !";		
	}
	#// Menampilkan Pesan Error dari Form
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		// SKRIP SIMPAN DATA KE DATABASE
		$kodeBaru	= "";
		
		// Skrip simpan data ke database
		$mySql	= "INSERT INTO dep (dep,name, chtime, chuser) VALUES ('$txtKode','$txtNama',getdate(),'$userLogin')";
//		echo $mySql;
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?open=Dept-Data'>";
		exit;	
	}	
}


// Membuat variabel isi ke form
$dataKode 		= isset($_POST['txtkode']) ? $_POST['txtkode'] : '';
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';

# JIKA TOMBOL CARI NASABAH DIKLIK
$dataNamaNas	= "";
$my2Sql	= "SELECT * FROM dep WHERE dep='$dataKode'";
$my2Qry	= sqlsrv_query($koneksidb, $my2Sql);
if(sqlsrv_num_rows($my2Qry) >=1) {
	$my2Data		= sqlsrv_fetch_array($my2Qry);
}
else {
}

?>

<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form1" target="_self">
  <table class="table-list" width="810" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>TAMBAH DATA KATEGORI </strong></td>
    </tr>
    <tr>
      <td width="133"><strong>Kode</strong></td>
      <td width="7"><strong>:</strong></td>
      <td width="644"><input name="txtKode" type="text" id="txtKode" value="<?php echo $dataKode; ?>" size="15" maxlength="15" /></td>
    </tr>
    <tr>
      <td><strong>Nama  </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" type="text" id="txtNama" value="<?php echo $dataNama; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" id="btnSimpan" value=" Simpan " /></td>
    </tr>
  </table>
</form>

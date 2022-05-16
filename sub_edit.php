<?php
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php"; 
//include_once "library/inc.library.php";

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Data dari Form Input
	$txtKode		= $_POST['txtKode'];
	$txtNama		= $_POST['txtNama'];
	$txtalamat		= $_POST['txtalamat'];
	$txtKota		= $_POST['txtKota'];
	$txtTelp		= $_POST['txtTelp'];
	$txtHP			= $_POST['txtHP'];
 
   # Validasi Form Input 
	// Validasi Form Input
	$pesanError = array();
	if (trim($txtKode)=="") {
		$pesanError[] = "Data <b>Kode </b> tidak boleh kosong !";		
	}
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama </b> tidak boleh kosong !";		
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
		$mySql	= "update sub set name='$txtNama',kota='$txtKota', phone='$txtTelp',hp='$txtHP', address='$txtalamat',grup='1' where sub='$txtKode'";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?open=Supplier-Data'>";
		exit;	
	}	
}

// Membuat variabel isi ke form
$dataKode 		= "";
$Kode	 = $_GET['Kode']; 
$mySql	 = "SELECT * FROM sub WHERE sub='$Kode'";
$myQry	 = sqlsrv_query($koneksidb, $mySql) ;
$myData	 = sqlsrv_fetch_array($myQry);

// Membuat variabel isi ke form 
$dataKode= $myData['sub'];
//$dataKode 		= isset($_POST['txtkode']) ? $_POST['txtkode'] : '';
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['name'];
$dataalamat 	= isset($_POST['txtalamat']) ? $_POST['txtalamat'] : $myData['address'];
$dataKota 		= isset($_POST['txtKota']) ? $_POST['txtKota'] : $myData['kota'];
$dataTelp 		= isset($_POST['txtTelp']) ? $_POST['txtTelp'] : $myData['phone'];
$dataHP 		= isset($_POST['txtHP']) ? $_POST['txtHP'] : $myData['hp'];
$datagrup		= isset($_POST['cmbgrup']) ? $_POST['cmbgrup'] : $myData['grup'];

?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form1" target="_self">
  <table class="table-list" width="776" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>UBAH DATA SUB ACCOUNT </strong></td>
    </tr>
    <tr>
      <td width="110"><strong>Kode</strong></td>
      <td width="9"><strong>:</strong></td>
      <td width="631"><input name="txtKode" type="text" id="txtKode" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly">
        <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Nama  </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" type="text" id="txtNama" value="<?php echo $dataNama; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Alamat</strong></td>
      <td><strong>:</strong></td>
    <td><input name="txtalamat" type="text" id="txtalamat" value="<?php echo $dataalamat; ?>" size="100" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Kota </strong></td>
      <td><strong>:</strong></td>
  	  <td><input name="txtKota" type="text" id="txtKota" value="<?php echo $dataKota; ?>" size="100" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Telp </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTelp" type="text" id="txtTelp" value="<?php echo $dataTelp; ?>" size="100" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>HP </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtHP" type="text" id="txtHP" value="<?php echo $dataHP; ?>" size="100" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" id="btnSimpan" value=" Simpan " /></td>
    </tr>
  </table>
</form>

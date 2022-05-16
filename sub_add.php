<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.seslogin.php"; 

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
	$mySql	= "select * from sub where sub='" . trim($txtKode) . "'";
	$myQry = sqlsrv_query( $koneksidb, $mySql);
	$myData= sqlsrv_fetch_array($myQry);
	if($myData['sub']<>'') {
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
		$mySql	= "INSERT INTO sub (sub, sub1, name, id, acc, accum, accgiro, accdisc, accppn, address, kota, area, phone, fax, hp, chtime, chuser, grup, limit) VALUES ('$txtKode','','$txtNama','', '301', '','', '','','$txtalamat','$txtKota','','$txtTelp','','$txtHP',getdate(),'$userLogin','1',0)";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?open=Supplier-Data'>";
		exit;	
	}	
}


// Membuat variabel isi ke form
$dataKode 		= isset($_POST['txtkode']) ? $_POST['txtkode'] : '';
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataalamat 	= isset($_POST['txtalamat']) ? $_POST['txtalamat'] : '';
$dataKota		= isset($_POST['txtKota']) ? $_POST['txtKota'] : '';
$dataTelp		= isset($_POST['txtTelp']) ? $_POST['txtTelp'] : '';
$dataHP			= isset($_POST['txtHP']) ? $_POST['txtHP'] : '';

# JIKA TOMBOL CARI NASABAH DIKLIK

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
      <td colspan="3" bgcolor="#CCCCCC"><strong>TAMBAH DATA SUPPLIER </strong></td>
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
      <td><strong>Alamat</strong></td>
      <td><strong>:</strong></td>
    <td><input name="txtalamat" type="text" id="txtalamat" value="<?php echo $dataalamat; ?>" size="100" maxlength="100" />    </tr>
    <tr>
      <td><strong>Kota</strong></td>
      <td><strong>:</strong></td>
	  <td><input name="txtKota" type="text" id="txtKota" value="<?php echo $dataKota; ?>" size="100" maxlength="100" />    </tr>
    <tr>
      <td><strong>Telp</strong></td>
      <td><strong>:</strong></td>
	  <td><input name="txtTelp" type="text" id="txtTelp" value="<?php echo $dataTelp; ?>" size="100" maxlength="100" />    </    </tr>
    <tr>
      <td><strong>HP</strong></td>
      <td><strong>:</strong></td>
	  <td><input name="txtHP" type="text" id="txtHP" value="<?php echo $dataHP; ?>" size="100" maxlength="100" />    </    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" id="btnSimpan" value=" Simpan " /></td>
    </tr>
  </table>
</form>

<?php
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php"; 
//include_once "library/inc.library.php";

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Data dari Form Input
	$txtKode		= $_POST['txtKode'];
	$txtNama		= $_POST['txtNama'];
	$txtUnit		= $_POST['txtUnit'];
	$txtBprice		= $_POST['txtBprice'];
	$txtPrice1		= $_POST['txtPrice1'];

   # Validasi Form Input 
	// Validasi Form Input
	$pesanError = array();
	if (trim($txtKode)=="") {
		$pesanError[] = "Data <b>Kode </b> tidak boleh kosong !";		
	}
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama </b> tidak boleh kosong !";		
	}
	if (trim($txtUnit)=="") {
		$pesanError[] = "Data <b>Unit </b> tidak boleh kosong !";		
	}
	if (trim($txtBprice)=="") {
		$txtBprice=0;		
	}
	if (trim($txtPrice1)=="") {
		$txtPrice1=0;		
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
		$mySql	= "update inv set name='$txtNama',unit='$txtUnit',bprice='$txtBprice',price1='$txtPrice1' where inv='$txtKode'";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?open=Inventory-Data'>";
		exit;	
	}	
}

// Membuat variabel isi ke form
$dataKode 		= "";
$Kode	 = $_GET['Kode']; 
$mySql	 = "SELECT * FROM inv WHERE inv='$Kode'";
$myQry	 = sqlsrv_query($koneksidb, $mySql) ;
$myData	 = sqlsrv_fetch_array($myQry);

// Membuat variabel isi ke form 
$dataKode= $myData['inv'];
//$dataKode 		= isset($_POST['txtkode']) ? $_POST['txtkode'] : '';
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['name'];
$dataUnit 		= isset($_POST['txtUnit']) ? $_POST['txtUnit'] : $myData['unit'];
$dataBprice		= isset($_POST['txtBprice']) ? $_POST['txtBprice'] : $myData['bprice'];
$dataPrice1 	= isset($_POST['txtPrice1']) ? $_POST['txtPrice1'] : $myData['price1'];

?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form1" target="_self">
  <table class="table-list" width="776" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>UBAH DATA INVENTORY </strong></td>
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
      <td><strong>Unit  </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtUnit" type="text" id="txtUnit" value="<?php echo $dataUnit; ?>" size="3" maxlength="3" /></td>
    </tr>
	<tr>
      <td><strong> Harga Beli </strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <input align="right" name="txtBprice" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $dataBprice; ?>" size="20" maxlength="12"/>
      </b></td>
    </tr>
	<tr>
      <td><strong> Harga Jual </strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <input align="right" name="txtPrice1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $dataPrice1; ?>" size="20" maxlength="12"/>
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" id="btnSimpan" value=" Simpan " /></td>
    </tr>
  </table>
</form>

<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.seslogin.php"; 

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Data dari Form Input
	$txtKode		= $_POST['txtKode'];
	$txtNama		= $_POST['txtNama'];
	$txtinduk		= $_POST['txtinduk'];
	$cmbdk			= $_POST['cmbdk'];
	$cmbdetil		= $_POST['cmbdetil'];
	$cmbgrup		= $_POST['cmbgrup'];
 
   # Validasi Form Input 
	// Validasi Form Input
	$pesanError = array();
	if (trim($txtKode)=="") {
		$pesanError[] = "Data <b>Kode COA</b> tidak boleh kosong !";		
	}
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama COA</b> tidak boleh kosong !";		
	}
	if (trim($txtinduk)=="") {
		$pesanError[] = "Data <b>Induk</b> tidak boleh kosong !";		
	}
	if (trim($cmbdk)=="Kosong") {
		$pesanError[] = "Data <b>DK</b> belum ada yang dipilih !";		
	}
	if (trim($cmbdetil)=="Kosong") {
		$pesanError[] = "Data <b>Detil</b> belum ada yang dipilih !";		
	}
	if (trim($cmbgrup)=="Kosong") {
		$pesanError[] = "Data <b>Grup</b> belum ada yang dipilih !";		
	}
	$mySql	= "select * from acc where kdac='" . trim($txtKode) . "'";
	$myQry = sqlsrv_query( $koneksidb, $mySql);
	$myData= sqlsrv_fetch_array($myQry);
	if($myData['kdac']<>'') {
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
		$mySql	= "INSERT INTO acc (kdac, nmac, induk, dk,
				 detil, grup) VALUES ('$txtKode', '$txtNama', '$txtinduk', '$cmbdk', 
			 '$cmbdetil', '$cmbgrup')";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?open=Account-Add'>";
		exit;	
	}	
}


// Membuat variabel isi ke form
$dataKode 		= isset($_POST['txtkode']) ? $_POST['txtkode'] : '';
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$datainduk 		= isset($_POST['txtinduk']) ? $_POST['txtinduk'] : '';
$datadk			= isset($_POST['cmbdk']) ? $_POST['cmbdk'] : '';
$datadetil	  	= isset($_POST['cmbdetil']) ? $_POST['cmbdetil'] : '';
$datagrup		= isset($_POST['cmbgrup']) ? $_POST['cmbgrup'] : '';
$dataBulanLhr	= isset($_POST['cmbBulanLhr']) ? $_POST['cmbBulanLhr'] : '';
$dataTahunLhr	= isset($_POST['cmbTahunLhr']) ? $_POST['cmbTahunLhr'] : '';
$dataAlamat 	= isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataNoTelepon 	= isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : '';

$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';
$dataPasangan	= isset($_POST['txtNmPasangan']) ? $_POST['txtNmPasangan'] : '';
$dataPekerjaan	= isset($_POST['txtNmPekerjaan']) ? $_POST['txtNmPekerjaan'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form1" target="_self">
  <table class="table-list" width="700" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td width="212" bgcolor="#CCCCCC"><strong>TAMBAH DATA COA </strong></td>
      <td width="6">&nbsp;</td>
      <td width="456">&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Kode</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKode" type="text" id="txtKode" value="<?php echo $dataKode; ?>" size="15" maxlength="15" /></td>
    </tr>
    <tr>
      <td><strong>Nama  </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" type="text" id="txtNama" value="<?php echo $dataNama; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Induk </strong></td>
      <td><strong>:</strong></td>
    <td><input name="txtinduk" type="text" id="txtinduk" value="<?php echo $datainduk; ?>" size="15" maxlength="100" />    </tr>
    <tr>
      <td><strong>DK</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbdk">
        <option value="Kosong">....</option>
        <?php
		  $pilihan = array("D", "K");
		  foreach ($pilihan as  $nilai) {
			if ($dataDK==$nilai) {
				$cek=" selected";
			} else { $cek = ""; }
			echo "<option value='$nilai' $cek> $nilai</option>";
		  }
		  ?>
      </select></td>
    </tr>
    <tr>
      <td><strong>Detil</strong></td>
      <td><strong>:</strong></td>
      <td><label>
        <select name="cmbdetil" id="cmbdetil">
          <option value="Kosong">....</option>
          <?php
		  $pilihan = array("T", "F");
		  foreach ($pilihan as  $nilai) {
			if ($datadetil==$nilai) {
				$cek=" selected";
			} else { $cek = ""; }
			echo "<option value='$nilai' $cek> $nilai</option>";
		  }
		  ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td><strong>Grup</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbgrup" id="cmbgrup">
        <option value="Kosong">....</option>
        <?php
		  $pilihan = array("1", "2","3","4","5");
		  foreach ($pilihan as  $nilai) {
			if ($datagrup==$nilai) {
				$cek=" selected";
			} else { $cek = ""; }
			echo "<option value='$nilai' $cek> $nilai</option>";
		  }
		  ?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>1 : Aktifa</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>2 : Kewajiban</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>3 : Modal</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>4 : Pendapatan</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>5 : Biaya</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" id="btnSimpan" value=" Simpan "></td>
    </tr>
  </table>
</form>

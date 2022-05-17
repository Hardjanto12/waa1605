<div class="form-group row">
    <button type="submit" name="btnSimpan" class="btn btn-primary btn-lg btn-block" id="btnSimpan"
        value=" Simpan ">Simpan</button>
    <!-- <button ttype="cancel" name="btnCancel" class="btn btn-danger btn-lg btn-block" id="btnCancel"
                    value=" Cancel ">Batalkan</button> -->
</div><?php
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php"; 
//include_once "library/inc.library.php";

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Data dari Form Input
//	$txtKode		= $_POST['txtKode'];
	$txtNama		= $_POST['txtNama'];
	$txtinduk		= $_POST['txtinduk'];
	$cmbdk			= $_POST['cmbdk'];
	$cmbdetil		= $_POST['cmbdetil'];
	$cmbgrup		= $_POST['cmbgrup'];
 
   # Validasi Form Input 
	// Validasi Form Input
	$pesanError = array();
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
		$kodeNasabah	= $_POST['txtKode'];
		
		
		// Skrip simpan data ke database
		$mySql 	= "UPDATE acc SET nmac='$txtNama', induk='$txtinduk', dk='$cmbdk', 
						detil='$cmbdetil', grup='$cmbgrup'
					WHERE kdac='$kodeNasabah'";
					
		$myQry	= sqlsrv_query($koneksidb, $mySql) ;
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Account-Data'>";
		}
		exit;	
	}	
}

// Membuat variabel isi ke form
$dataKode 		= "";
$Kode	 = $_GET['Kode']; 
$mySql	 = "SELECT * FROM acc WHERE kdac='$Kode'";
$myQry	 = sqlsrv_query($koneksidb, $mySql) ;
$myData	 = sqlsrv_fetch_array($myQry);

// Membuat variabel isi ke form 
$dataKode= $myData['kdac'];
//$dataKode 		= isset($_POST['txtkode']) ? $_POST['txtkode'] : '';
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nmac'];
$datainduk 		= isset($_POST['txtinduk']) ? $_POST['txtinduk'] : $myData['induk'];
$datadk			= isset($_POST['cmbdk']) ? $_POST['cmbdk'] : $myData['dk'];
$datadetil	  	= isset($_POST['cmbdetil']) ? $_POST['cmbdetil'] : $myData['detil'];
$datagrup		= isset($_POST['cmbgrup']) ? $_POST['cmbgrup'] : $myData['grup'];

?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form1" target="_self">

    <div class="container-fluid mb-5">
        <h1 class=" display-6">Data COA</h1>
    </div>
    <div class="container">
        <!-- KODE -->
        <div class="form-group row mb-2">
            <label class="col-sm-2 col-form-label" for="txtKode"><b>Kode :</b></label>
            <div class="col-sm-10">
                <input name="txtKode" type="text" class="form-control mb-2 mr-sm-2" placeholder="Masukkan Kode"
                    id="txtKode" value="<?php echo $dataKode; ?>" readonly>
            </div>
        </div>
        <!-- NAMA -->
        <div class="form-group row mb-2">
            <label class="col-sm-2 col-form-label" for="txtNama">Nama:</label>
            <div class="col-sm-10">
                <input name="txtNama" type="text" class="form-control mb-2 mr-sm-2" placeholder="Masukkan Nama"
                    id="txtNama" value="<?php echo $dataNama; ?>">
            </div>
        </div>
        <!-- INDUK -->
        <div class="form-group row mb-2">
            <label class="col-sm-2 col-form-label" for="txtInduk">Induk:</label>
            <div class="col-sm-10">
                <input name="txtinduk" type="text" class="form-control mb-2 mr-sm-2" placeholder="Masukkan Induk"
                    id="txtinduk" value="<?php echo $datainduk; ?>">
            </div>
        </div>
        <!-- DK -->
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label" for="cmbdk">DK:</label>
            <div class="col-sm-10">
                <select class="custom-select" id="cmbdk" name="cmbdk">
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
                </select>
            </div>
        </div>
        <!-- Detil -->
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label" for="cmbdetil">Detil:</label>
            <div class="col-sm-10">
                <select class="custom-select" id="cmbdetil" name="cmbdetil">
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
            </div>
        </div>
        <!-- Grup -->
        <div class="form-group row mb-2">
            <label class="col-sm-2 col-form-label" for="cmbgrup">Grup:</label>
            <div class="col-sm-10">
                <select class="custom-select" id="cmbgrup" name="cmbgrup" data-toggle="popover">
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
                </select>
                <small id="grupHelp" class="form-text text-muted">
                    1 = Aktifa <br> 2 = Kewajiban <br> 3 = Modal <br> 4 = Pendapatan
                    <br> 5 = Biaya
                </small>
            </div>
        </div>
        <div class="form-group row">
            <button type="submit" name="btnSimpan" class="btn btn-primary btn-lg btn-block" id="btnSimpan"
                value=" Simpan ">Simpan</button>
            <!-- <button ttype="cancel" name="btnCancel" class="btn btn-danger btn-lg btn-block" id="btnCancel"
                    value=" Cancel ">Batalkan</button> -->
        </div>
    </div>
</form>
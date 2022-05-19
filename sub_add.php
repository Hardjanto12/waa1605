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

    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form1"
        target="_self">
        <div class="container-fluid mb-5">
            <h1 class=" display-6">Tambah Data Suplier</h1>
        </div>
        <div class="container">
            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label" for="txtKode">Kode:</label>
                <div class="col-sm-10">
                    <input name="txtKode" type="text" class="form-control mb-2 mr-sm-2" placeholder="Masukkan Kode"
                        id="txtKode" value="<?php echo $dataKode; ?>">
                </div>
            </div>

            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label" for="txtNama">Nama:</label>
                <div class="col-sm-10">
                    <input name="txtNama" type="text" class="form-control mb-2 mr-sm-2" placeholder="Masukkan Nama"
                        id="txtNama" value="<?php echo $dataNama; ?>">
                </div>
            </div>

            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label" for="txtalamat">Alamat:</label>
                <div class="col-sm-10">
                    <input name="txtalamat" type="text" class="form-control mb-2 mr-sm-2" placeholder="Masukkan alamat"
                        id="txtalamat" value="<?php echo $dataalamat; ?>">
                </div>
            </div>

            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label" for="txtKota">Kota:</label>
                <div class="col-sm-10">
                    <input name="txtKota" type="text" class="form-control mb-2 mr-sm-2" placeholder="Masukkan kota"
                        id="txtKota" value="<?php echo $dataKota; ?>">
                </div>
            </div>

            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label" for="txtTelp">Telp:</label>
                <div class="col-sm-10">
                    <input name="txtTelp" type="text" class="form-control mb-2 mr-sm-2"
                        placeholder="Masukkan no telepon" id="txtTelp" value="<?php echo $dataTelp; ?>">
                </div>
            </div>

            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label" for="txtHP">HP:</label>
                <div class="col-sm-10">
                    <input name="txtHP" type="text" class="form-control mb-2 mr-sm-2" placeholder="Masukkan no telepon"
                        id="txtHP" value="<?php echo $dataHP; ?>">
                </div>
            </div>

            <div class="form-group row">
                <button type="submit" name="btnSimpan" class="btn btn-primary btn-lg btn-block" id="btnSimpan"
                    value=" Simpan ">Simpan</button>
                <!-- <button ttype="cancel" name="btnCancel" class="btn btn-danger btn-lg btn-block" id="btnCancel"
                    value=" Cancel ">Batalkan</button> -->
            </div>
    </form>
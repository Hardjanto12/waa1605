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
	$mySql	= "select * from inv where inv='" . trim($txtKode) . "'";
	$myQry = sqlsrv_query( $koneksidb, $mySql);
	$myData= sqlsrv_fetch_array($myQry);
	if($myData['inv']<>'') {
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
		$mySql	= "INSERT INTO inv (inv,name,unit,bprice,price1,chtime,chuser) VALUES ('$txtKode','$txtNama','$txtUnit','$txtBprice','$txtPrice1',getdate(),'$userLogin')";
//		echo $mySql;
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?open=Inventory-Data'>";
		exit;	
	}	
}


// Membuat variabel isi ke form
$dataKode 		= isset($_POST['txtkode']) ? $_POST['txtkode'] : '';
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataUnit 		= isset($_POST['txtUnit']) ? $_POST['txtUnit'] : '';
$dataBprice		= isset($_POST['txtBprice']) ? $_POST['txtBprice'] : '';
$dataPrice1 	= isset($_POST['txtPrice1']) ? $_POST['txtPrice1'] : '';

# JIKA TOMBOL CARI NASABAH DIKLIK
$dataNamaNas	= "";
$my2Sql	= "SELECT * FROM inv WHERE inv='$dataKode'";
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

    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form1"
        target="_self">
        <div class="container-fluid mb-5">
            <h1 class=" display-6">Tambah Data Inventory</h1>
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
                <label class="col-sm-2 col-form-label" for="txtUnit">Unit:</label>
                <div class="col-sm-3">
                    <input name="txtUnit" type="text" id="txtUnit" value="<?php echo $dataUnit; ?>"
                        class="form-control mb-2 mr-sm-2" placeholder="Masukkan unit" maxlength="3">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label" for="txtBprice">Harga Beli:</label>
                <div class="col-sm-10">
                    <input name="txtBprice" type="text" class="form-control mb-2 mr-sm-2"
                        placeholder="Masukkan harga beli"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                        value="<?php echo $dataBprice; ?>" size="20" maxlength="12">
                </div>
            </div>
            <!-- harga jual -->
            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label" for="txtPrice1">Harga Jual:</label>
                <div class="col-sm-10">
                    <input name="txtPrice1" type="text" class="form-control mb-2 mr-sm-2"
                        placeholder="Masukkan harga jual"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                        value="<?php echo $dataBprice; ?>" size="20" maxlength="12">
                </div>
            </div>
            <div class="form-group row">
                <button type="submit" name="btnSimpan" class="btn btn-primary btn-lg btn-block" id="btnSimpan"
                    value=" Simpan ">Simpan</button>
            </div>
        </div>
    </form>
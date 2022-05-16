<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";

# Jenis Terpilih
$jenis		= isset($_GET['jenis']) ? $_GET['jenis'] : 'Kosong'; // Baca dari URL 
$dataJenis 	= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : $jenis; // Baca dari form Submit, jika tidak ada diisi dari $jenis

# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnKosong'])){
?>
<div class="btn-group pull-right">
	<button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown">Export <span class="caret"></span></button>
	<ul class="dropdown-menu" role="menu">
		<li><a class="dataExport" data-type="csv">CSV</a></li>
		<li><a class="dataExport" data-type="excel">XLS</a></li>          
		<li><a class="dataExport" data-type="txt">TXT</a></li>			 			  
	</ul>
</div>
<?php
	$tanggal_1 	= isset($_GET['tanggal_1']) ? $_GET['tanggal_1'] : "01-".date('m-Y');
	$tanggal_1 	= isset($_POST['cmbTanggal_1']) ? $_POST['cmbTanggal_1'] : $tanggal_1;
	$tanggal_11 = InggrisTgl($tanggal_1);
		
	$tanggal_2 	= isset($_GET['tanggal_2']) ? $_GET['tanggal_2'] : date('d-m-Y'); 
	$tanggal_2 	= isset($_POST['cmbTanggal_2']) ? $_POST['cmbTanggal_2'] : $tanggal_2;
	$tanggal_22 = InggrisTgl($tanggal_2);
	$txtPrj				= $_POST['txtPrj'];
	$txtMsn				= $_POST['txtMsn'];
	$txtAcc				= $_POST['txtAcc'];

	$dataSub		= "";

	// Baca variabel data form
	// Skrip Validasi form
//	header("Content-type: application/vnd-ms-excel");
//	header("Content-Disposition: attachment; filename=Data Penjualan.xls");
	?>
<table id="dataTable" class="table table-striped"  width="894" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="21" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="78" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="73" bgcolor="#CCCCCC"><strong>No Transaksi </strong></td>
    <td width="62" bgcolor="#CCCCCC"><strong>Remark </strong></td>
    <td width="64" bgcolor="#CCCCCC"><strong>Proyek </strong></td>
    <td width="78" bgcolor="#CCCCCC"><strong>Mesin</strong></td>
    <td width="91" bgcolor="#CCCCCC"><strong>Account</strong></td>
    <td width="63" bgcolor="#CCCCCC"><strong>Nama Account </strong></td>
    <td width="54" bgcolor="#CCCCCC"><strong>Nilai </strong></td>
  </tr>
	    <?php 
		// Skrip menampilkan data Peminjaman dengan filter Periode
	$mySql = "select a.nojnl, convert(varchar,a.date,111) as tgl, a.remark, a.chuser, a.chtime, b.acc, b.prj, b.msn, b.acc, d.nmac as namaacc, b.val, b.dtseq from boh a inner join bod b on a.nojnl=b.nojnl inner join acc d on b.acc=d.kdac WHERE a.control='1' and b.stt='1' and a.date>='$tanggal_11' and a.date<='$tanggal_22' ";
//		echo trim($txtInv);
//		echo $mySql . " and b.inv='$txtInv' ";
		if (trim($txtPrj)<>""){
			$mySql = $mySql . " and b.prj='$txtPrj' ";
		}
		if (trim($txtMsn)<>""){
			$mySql = $mySql . " and b.msn='$txtMsn' ";
		}
		if (trim($txtAcc)<>""){
			$mySql = $mySql . " and b.acc='$txtAcc' ";
		}
//		$mySql = "exec [ProcOmsetCustMBR] '$tanggal_11', '$tanggal_22', ''";
//		$mySql = "select * from mdepo where mdplev=4";
//		echo $mySql;
		$myQry = sqlsrv_query($koneksidb, $mySql);
		$nomor = 0;  
		$ttl = 0;  
		while ($myData = sqlsrv_fetch_array($myQry)) {
			$nomor++;
			$ttl= $ttl + $myData['val']
		?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo IndonesiaTgl($myData['tgl']); ?></td>
			<td><?php echo $myData['nojnl']; ?></td>
			<td><?php echo $myData['remark']; ?></td>
			<td><?php echo $myData['prj']; ?></td>
			<td><?php echo $myData['msn']; ?></td>
			<td><?php echo $myData['acc']; ?></td>
			<td><?php echo $myData['namaacc']; ?></td>
			<td><?php echo format_angka($myData['val']); ?></td>
		</tr>
		<?php 
		} ?>
			<td>&nbsp</td>
			<td>&nbsp</td>
			<td>&nbsp</td>
			<td>&nbsp</td>
			<td>&nbsp</td>
			<td>&nbsp</td>
			<td>&nbsp</td>
			<td>&nbsp</td>
			<td><?php echo format_angka($ttl); ?></td>
		<?php 
		?>
</table>
		<?php 
		exit;	
		
 		# SIMPAN KE DATABASE
		// Jika jumlah error pesanError tidak ada, maka proses Penyimpanan akan dikalkukan
		
		
}


# Membuat filter Jenis
if($dataJenis =="Kosong") {
	$filterJenisSQL	= "";
}
else {
	$filterJenisSQL	= " AND pinjaman.kd_jpinjaman='$dataJenis'";
}

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tanggal_1 	= isset($_GET['tanggal_1']) ? $_GET['tanggal_1'] : "01-".date('m-Y');
$tanggal_1 	= isset($_POST['cmbTanggal_1']) ? $_POST['cmbTanggal_1'] : $tanggal_1;
$tanggal_11 = InggrisTgl($tanggal_1);

$tanggal_2 	= isset($_GET['tanggal_2']) ? $_GET['tanggal_2'] : date('d-m-Y'); 
$tanggal_2 	= isset($_POST['cmbTanggal_2']) ? $_POST['cmbTanggal_2'] : $tanggal_2;
$tanggal_22 = InggrisTgl($tanggal_2);

$dataSub		= isset($_POST['txtSub']) ? $_POST['txtSub'] : '';
$dataNamaSub		= isset($_POST['txtNamaSub']) ? $_POST['txtNamaSub'] : '';
$dataPrj		= isset($_POST['txtPrj']) ? $_POST['txtPrj'] : '';
$dataMsn		= isset($_POST['txtMsn']) ? $_POST['txtMsn'] : '';
$dataAcc		= isset($_POST['txtInv']) ? $_POST['txtInv'] : '';
$dataNamaAcc		= isset($_POST['txtNamaInv']) ? $_POST['txtNamaInv'] : '';

// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
$filterSQL = " WHERE ( pinjaman.tgl_pinjaman BETWEEN '$tanggal_11' AND '$tanggal_22') $filterJenisSQL";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT top 1 * FROM mvoucher ";
//echo $pageSql;
$pageQry= sqlsrv_query($koneksidb, $pageSql) ;
$jumlah	= 0; //mysql_num_rows($pageQry);
$maks	= 0; //ceil($jumlah/$baris);
$mulai	= 0; //$baris * ($hal-1); 
?>
<h2>LAPORAN BIAYA OVERHEAD PER PERIODE </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    
    <tr>
      <td bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Periode Tanggal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="cmbTanggal_1" type="text" class="tcal" value="<?php echo $tanggal_1; ?>" size="17" />
s/d
  <input name="cmbTanggal_2" type="text" class="tcal" value="<?php echo $tanggal_2; ?>" size="17" /></td>
    </tr>
    <tr>
      <td><strong>Proyek</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtPrj" id="txtPrj" size="20" maxlength="6" value="<?php echo $dataPrj; ?>" onchange="javascript:submitform();" />
<a href="prj_cari.php"
   onclick="window.open(this.href,'targetWindow',
                                   `toolbar=no,
                                    location=no,
                                    status=no,
                                    menubar=no,
                                    scrollbars=yes,
                                    resizable=yes,
                                    width=SomeSize,
                                    height=SomeSize`);
 return false;">Cari</a>    </tr>
    <tr>
      <td><strong>Mesin</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtMsn" id="txtMsn" size="20" maxlength="6" value="<?php echo $dataMsn; ?>" onchange="javascript:submitform();" />
<a href="msn_cari.php"
   onclick="window.open(this.href,'targetWindow',
                                   `toolbar=no,
                                    location=no,
                                    status=no,
                                    menubar=no,
                                    scrollbars=yes,
                                    resizable=yes,
                                    width=SomeSize,
                                    height=SomeSize`);
 return false;">Cari</a>    </tr>
    <tr>
      <td><strong>Account</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtAcc" id="txtAcc" size="20" maxlength="15" value="<?php echo $dataAcc; ?>" onchange="javascript:submitform();" />
<a href="acc_cari.php"
   onclick="window.open(this.href,'targetWindow',
                                   `toolbar=no,
                                    location=no,
                                    status=no,
                                    menubar=no,
                                    scrollbars=yes,
                                    resizable=yes,
                                    width=SomeSize,
                                    height=SomeSize`);
 return false;">Cari</a>    </tr>
    <tr>
      <td width="139">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td width="737"><input name="btnKosong" type="submit" id="btnKosong" style="cursor:pointer;" value="PREVIEW" /></td>
    </tr>
  </table>
</form>

<br />

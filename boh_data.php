<?php
include_once "library/inc.seslogin.php"; 
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";

// Membaca nama form
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : date('m'); 
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : date('Y'); 
$Tahun	=	substr($dataTahun,2,2);
# Membuat Filter Bulan
if($dataTahun and $dataBulan) {
	$filterSQL = "WHERE a.control<>'6' and substring(a.nojnl,6,2)='$Tahun' AND substring(nojnl,8,2)='$dataBulan'"; 
}
else {
	$filterSQL = "WHERE a.control<>'6'"; 
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;
$infoSql= "SELECT * FROM boh $filterSQL"; 
$infoQry= sqlsrv_query($koneksidb, $infoSql );
$jumlah	= 0; //sqlsrv_num_rows($infoQry);
$maks	= ceil($jumlah/$baris);
$mulai	= $baris * ($hal-1);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Data Biaya Overhead</title></head>

<body>
<h1> BIAYA OVERHEAD </h1>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list"  width="800" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td width="157" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
      <td width="6">&nbsp;</td>
      <td width="611">&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Bulan &amp; Tahun </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbBulan">
          <?php
	for($bulan = 1; $bulan <= 12; $bulan++) {
		// Skrip membuat angka 2 digit (1-9)
		if($bulan < 10) { $bln = "0".$bulan; } else { $bln = $bulan; }
		
		if ($bln == $dataBulan) { $cek=" selected"; } else { $cek = ""; }
		
		echo "<option value='$bln' $cek> $listBulan[$bln] </option>";
	}
	?>
        </select>
          <select name="cmbTahun">
            <?php
	$awal_th	= date('Y') - 3;
	for($tahun = $awal_th; $tahun <= date('Y'); $tahun++) {
	// Skrip tahun terpilih
	if ($tahun == $dataTahun) {  $cek=" selected"; } else { $cek = ""; }
	
	echo "<option value='$tahun' $cek> $tahun </option>";
	}
	?>
          </select>
          <input name="btnTampil" type="submit" id="btnTampil" value="Tampil">      </td>
    </tr>
  <tr>
	</td>
  </tr>
  <tr>
  	<td >
	<div class="btn-group pull-left">
		<button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown">Export <span class="caret"></span></button>
		<ul class="dropdown-menu" role="menu">
			<li><a class="dataExport" data-type="csv">CSV</a></li>
			<li><a class="dataExport" data-type="excel">XLS</a></li>          
			<li><a class="dataExport" data-type="txt">TXT</a></li>			 			  
		</ul>
	</div>
	</td>
    <td colspan="2" align="right"><a href="?open=BiayaOverhead-Add" target="_self"><img src="images/btn_add_data.png" width="140" height="34" border="0"></a></td>
  </tr>
  </table>
</form>

<table id="dataTable" class="table-list" width="946" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="28" bgcolor="#CCCCCC"><strong>No.</strong></td>
    <td width="93" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="138" bgcolor="#CCCCCC"><strong>No. Jurnal </strong></td>
    <td width="220" bgcolor="#CCCCCC"><strong>Remark</strong></td>
    <td width="148" bgcolor="#CCCCCC"><div align="left"><strong>Created</strong></div></td>
    <td width="68" bgcolor="#CCCCCC"><div align="left"><strong>User </strong></div></td>
    <td width="69" bgcolor="#CCCCCC"><div align="left"><strong>Status </strong></div></td>
    <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  
<?php
// Skrip menampilkan data Transaksi Pinjaman
$mySql 	= "SELECT a.*,convert(varchar,a.date,111) as tgl, case when a.control='1' then 'SAVED' when a.control='7' then 'WAITING' else 'DELETED' end as stts FROM boh a  $filterSQL ORDER BY a.date ASC ";
//echo $mySql;
$myQry 	= sqlsrv_query($koneksidb,$mySql) ;
$nomor  = $mulai; 
while ($myData = sqlsrv_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['nojnl'];

	// Menghitng Total Saldo Simpanan Hasil Transaksi
//	$my2Sql	= "SELECT SUM(debit) AS total_debit,  SUM(kredit) AS total_kredit FROM simpanan_transaksi WHERE no_simpanan='$Kode'";
//	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah 2 : ".mysql_error());
//	$my2Data = mysql_fetch_array($my2Qry);
	
	// Mentotal Saldo Simpanan
//	$totalSaldo	= $my2Data['total_kredit'] - $my2Data['total_debit'];
?>
  <tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo IndonesiaTgl($myData['tgl']); ?> </td>
    <td> <?php echo $myData['nojnl']; ?> </td>
    <td> <?php echo $myData['remark']; ?>  </td>
    <td> <?php echo $myData['chtime']; ?>  </td>
    <td> <?php echo $myData['chuser']; ?>  </td>
    <td> <?php echo $myData['stts']; ?>  </td>
        <td width="24" align="center"><a href="?open=BiayaOverhead-Edit&Kode=<?php echo $Kode; ?>&Tanda=<?php echo "1"; ?>" target="_self" 
			onclick="return confirm('YAKIN INGIN MENGUBAH DATA BAGIAN INI ... ?')">Edit</a></td>
        <td width="39" align="center"><a href="?open=BiayaOverhead-Delete&Kode=<?php echo $Kode; ?>" target="_self" 
			onclick="return confirm('YAKIN INGIN MENGHAPUS DATA BAGIAN INI ... ?')">Delete</a></td>
    <td width="37"><a href="boh_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank">Cetak</a></td>
  </tr>
  
<?php } ?>

  <tr>
    <td colspan="3"><strong>Jumlah Data : <?php echo $nomor; ?> </strong></td>
    <td colspan="5" align="right"><strong>Halaman Ke : 
	<?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=BiayaOverhead-Data&hal=$h'>$h</a> ";
	}
	?> </strong> </td>
  </tr>
</table>
</body>
</html>

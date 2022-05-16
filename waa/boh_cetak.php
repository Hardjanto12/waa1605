<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";

# Baca noNota dari URL
if(isset($_GET['Kode'])){
	$Kode = $_GET['Kode'];
	
	// Perintah untuk mendapatkan data dari tabel simpanan
	$mySql = "select a.nojnl, convert(varchar,a.date,111) as tgl, a.remark, a.chuser, a.chtime, b.acc, d.nmac, b.prj, b.msn, b.val, b.dtseq from boh a inner join bod b on a.nojnl=b.nojnl  inner join acc d on b.acc=d.kdac WHERE a.nojnl='$Kode'";
	$myQry 	= sqlsrv_query($koneksidb,$mySql) ;
	$myData= sqlsrv_fetch_array($myQry);
}
else {
	echo "Nomor (Kode) tidak ditemukan";
	exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cetak Hasil Produksi</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body >
<table class="table-list"  width="700" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="155"><strong>No. Biaya Overhead </strong></td>
    <td width="10"><strong>:</strong></td>
    <td width="540"> <?php echo $myData['nojnl']; ?> </td>
  </tr>
  <tr>
    <td><strong>Tanggal  </strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo IndonesiaTgl($myData['tgl']); ?> </td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo $myData['remark']; ?> </td>
  </tr>
</table>
<br>
<table class="table-list"  width="700" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="20" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="56" bgcolor="#CCCCCC"><strong>Proyek </strong></td>
    <td width="56" bgcolor="#CCCCCC"><strong>Mesin </strong></td>
    <td width="109" bgcolor="#CCCCCC"><strong>Account </strong></td>
    <td width="157" bgcolor="#CCCCCC"><strong>Nama Account </strong></td>
    <td width="48" align="right" bgcolor="#CCCCCC"><strong>Nilai</strong></td>
  </tr>
  
<?php
# SKRIP TAMPILKAN DATA 
// Variabel
$total	= 0;

  // Skrip menampilkan data Simpanan
	$mySql = "select a.nojnl, convert(varchar,a.date,111) as tgl, a.remark, a.chuser, a.chtime, b.acc, d.nmac, b.prj, b.msn, b.val, b.dtseq from boh a inner join bod b on a.nojnl=b.nojnl  inner join acc d on b.acc=d.kdac WHERE a.nojnl='$Kode'";
	$myQry 	= sqlsrv_query($koneksidb,$mySql) ;
$nomor = 0; 
$dpp = 0; 
$ppn = 0; 
while ($myData = sqlsrv_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['nojnl'];
	$total	= $total + ($myData['val'] );
?>
<tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo $myData['prj']; ?> </td>
    <td> <?php echo $myData['msn']; ?> </td>
    <td> <?php echo $myData['acc']; ?> </td>
    <td> <?php echo $myData['nmac']; ?> </td>
    <td align="right"> <?php echo format_angka($myData['val']); ?> </td>
  </tr>
  
<?php  } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="56" bgcolor="#CCCCCC"><div align="right" class="style1"> <?php echo format_angka($total); ?></div></td>
    </tr>

</table>
</body>
</html>

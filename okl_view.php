<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# Baca noNota dari URL
if(isset($_GET['Kode'])){
	$Kode = $_GET['Kode'];
	$prd=substr($Kode,5,2) . substr($Kode,3,2);
	
	// Perintah untuk mendapatkan data dari tabel simpanan
	$mySql = "SELECT a.nojnl, CONVERT(varchar,date,111) as date, a.sub, c.name, a.remark as rem FROM okl a
				inner JOIN okd b ON a.nojnl = b.nojnl inner join sub c on a.sub=c.sub
				WHERE a.nojnl='$Kode'";
	$myQry = sqlsrv_query($koneksidb, $mySql);
	$myData = sqlsrv_fetch_array($myQry) ;
}
else {
	echo "Nomor Jurnal (Kode) tidak ditemukan";
	exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>View Order Penjualan</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body >
<table class="table-list"  width="700" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="155"><strong>No. Jurnal </strong></td>
    <td width="10"><strong>:</strong></td>
    <td width="540"> <?php echo $myData['nojnl']; ?> </td>
  </tr>
  <tr>
    <td><strong>Tgl. Jurnal </strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo IndonesiaTgl($myData['date']); ?> </td>
  </tr>
  <tr>
    <td><strong>Customer</strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo $myData['name']; ?> </td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo $myData['rem']; ?> </td>
  </tr>
</table>
<br>
<table class="table-list"  width="700" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="21" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="97" bgcolor="#CCCCCC"><strong>Inventory</strong></td>
    <td width="127" bgcolor="#CCCCCC"><strong>Nama Inventory</strong></td>
    <td width="102" align="right" bgcolor="#CCCCCC"><strong>Qty</strong></td>
    <td width="102" align="right" bgcolor="#CCCCCC"><strong>Harga</strong></td>
    <td width="102" align="right" bgcolor="#CCCCCC"><strong>Subtotal</strong></td>
  </tr>
  
<?php
# SKRIP TAMPILKAN DATA 
// Variabel
$saldoAkhir	= 0;

  // Skrip menampilkan data Simpanan
	$mySql = "SELECT a.nojnl, b.acc, c.nmac, b.remark, b.inv, b.qty, b.price, b.val  FROM okl a
				inner JOIN okd b ON a.nojnl = b.nojnl
				inner JOIN acc".$prd." c on b.acc=c.kdac
				inner JOIN inv d on b.inv=d.inv
				WHERE a.nojnl='$Kode'";
$myQry = sqlsrv_query($koneksidb, $mySql);
$nomor = 0; 
while ($myData = sqlsrv_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['nojnl'];
?>
<tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo $myData['inv']; ?> </td>
    <td width="193"> <?php echo $myData['remark']; ?> </td>
    <td align="right"> <?php echo format_angka($myData['qty']); ?> </td>
    <td align="right"> <?php echo format_angka($myData['price']); ?> </td>
    <td align="right"> <?php echo format_angka($myData['val']); ?> </td>
  </tr>
  
<?php  } ?>

</table>
</body>
</html>

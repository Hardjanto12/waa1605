<?php
// Koneksi database
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php"; 

# TOMBOL CARI
if(isset($_POST['btnCari'])) {
	$txtKataKunci	= $_POST['txtKataKunci'];
	$filterSQL 		= "WHERE a.control='6' and a.remark LIKE '%$txtKataKunci%' OR a.nojnl like '%$txtKataKunci%'";
}
else {
	$filterSQL 	= "WHERE a.control='6'  ";
}

// Variabel pada form cari
$dataKataKunci	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';

// Untuk pembagian halaman data (Paging)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;

$infoSql= "SELECT a.* FROM okl a $filterSQL";
$infoQry= sqlsrv_query($koneksidb , $infoSql) ;
$jumlah	= sqlsrv_num_rows($infoQry);
$maks	= ceil($jumlah/$baris); 
$mulai	= $baris * ($hal-1);
?>
<html>
<head>
<title>Data Approval Order Penjualan</title>
</head>
<body>

<table class="table-common" width="910" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td colspan="2"><strong>
    <h1>DATA APPROVAL ORDER PENJUALAN </h1>
    </strong></td>
  </tr>
  <tr>
    <td colspan="2">

  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
    <table width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="24%" bgcolor="#CCCCCC"><strong>PENCARIAN</strong></td>
        <td width="1%">&nbsp;</td>
        <td width="75%">&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Kode. / Keterangan </strong></td>
        <td>:</td>
        <td><input name="txtKataKunci" type="text" id="txtKataKunci" value="<?php echo $dataKataKunci; ?>" size="40" maxlength="100">
          <input name="btnCari" type="submit" id="btnCari" value="Cari"></td>
      </tr>
    </table>
  </form>	</td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="3%" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="13%" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="11%" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
        <td width="13%" bgcolor="#CCCCCC"><strong>Customer</strong></td>
        <td width="16%" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
        <td width="15%" bgcolor="#CCCCCC"><strong>Last Change</strong></td>
        <td width="12%" bgcolor="#CCCCCC"><strong>User</strong></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
      </tr>
      <?php
// Skrip menampilkan data Nasabah
$mySql 	= "SELECT a.nojnl,CONVERT(varchar,a.date,111) as date,b.name,a.remark,a.chuser,a.chtime,a.val FROM okl a inner join sub b on a.sub=b.sub $filterSQL ORDER BY a.nojnl ASC ";
$myQry 	= sqlsrv_query($koneksidb,$mySql) ;
$nomor  = $mulai; 
while ($myData = sqlsrv_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['nojnl'];
?>
      <tr>
        <td><?php echo $nomor; ?> </td>
        <td><?php echo $myData['nojnl']; ?> </td>
        <td><?php echo $myData['date']; ?> </td>
        <td><?php echo $myData['name']; ?> </td>
        <td><?php echo $myData['remark']; ?> </td>
        <td><?php echo $myData['chtime']; ?> </td>
        <td><?php echo $myData['chuser']; ?> </td>
        <td width="7%" align="center"><a href="?open=OrderPenjualan-Approve&Kode=<?php echo $Kode; ?>" target="_self" 
			onclick="return confirm('YAKIN INGIN APPROVE DATA BAGIAN INI ... ?')">Approve</a></td>
        <td width="5%" align="center"><a href="?open=OrderPenjualan-Reject&Kode=<?php echo $Kode; ?>" target="_self" 
			onclick="return confirm('YAKIN INGIN REJECT DATA BAGIAN INI ... ?')">Reject</a></td>
        <td width="5%" align="center"><a href="?open=OrderPenjualan-View&Kode=<?php echo $Kode; ?>" target="_self">View</a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td width="309"><strong>Jumlah Data : </strong>  <?php echo $jumlah; ?>  </td>
    <td width="373" align="right"><strong>Halaman Ke : </strong>

	<?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=OrderPenjualan-Data&hal=$h'>$h</a> ";
	}
	?></td>
  </tr>
</table>
</body>
</html>

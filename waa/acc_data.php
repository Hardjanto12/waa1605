<?php
// Koneksi database
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php"; 

# TOMBOL CARI
if(isset($_POST['btnCari'])) {
	$txtKataKunci	= $_POST['txtKataKunci'];
	$filterSQL 		= "WHERE nmac LIKE '%$txtKataKunci%' OR kdac like '%$txtKataKunci%'";
}
else {
	$filterSQL 	= "";
}

// Variabel pada form cari
$dataKataKunci	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';

// Untuk pembagian halaman data (Paging)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;

$infoSql= "SELECT * FROM acc $filterSQL";
$infoQry= sqlsrv_query($koneksidb , $infoSql) ;
$jumlah	= sqlsrv_num_rows($infoQry);
$maks	= ceil($jumlah/$baris); 
$mulai	= $baris * ($hal-1);
?>
<html>
<head>
<title>Data COA</title>
</head>
<body>

<table class="table-common" width="700" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td colspan="2"><strong>
    <h1>DATA COA </h1>
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
        <td><strong>Kode. / Nama COA </strong></td>
        <td>:</td>
        <td><input name="txtKataKunci" type="text" id="txtKataKunci" value="<?php echo $dataKataKunci; ?>" size="40" maxlength="100">
          <input name="btnCari" type="submit" id="btnCari" value="Cari"></td>
      </tr>
    </table>
  </form>
	
	</td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?open=Account-Add" target="_self"><img src="images/btn_add_data.png" width="140" height="34" border="0"></a></td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="4%" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="8%" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="50%" bgcolor="#CCCCCC"><strong>Nama</strong></td>
        <td width="7%" bgcolor="#CCCCCC"><strong>Induk</strong></td>
        <td width="6%" bgcolor="#CCCCCC"><strong>DK</strong></td>
        <td width="6%" bgcolor="#CCCCCC"><strong>detil</strong></td>
        <td width="6%" bgcolor="#CCCCCC"><strong>grup</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
	  
<?php
// Skrip menampilkan data Nasabah
$mySql 	= "SELECT * FROM acc $filterSQL ORDER BY kdac ASC ";
$myQry 	= sqlsrv_query($koneksidb,$mySql) ;
$nomor  = $mulai; 
while ($myData = sqlsrv_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['kdac'];
?>	

      <tr>
        <td> <?php echo $nomor; ?> </td>
        <td> <?php echo $myData['kdac']; ?> </td>
        <td> <?php echo $myData['nmac']; ?> </td>
        <td> <?php echo $myData['induk']; ?> </td>
        <td> <?php echo $myData['dk']; ?> </td>
        <td> <?php echo $myData['detil']; ?> </td>
        <td> <?php echo $myData['grup']; ?> </td>
        <td width="11%" align="center"><a href="?open=Account-Delete&Kode=<?php echo $Kode; ?>" target="_self">Delete</a></td>
        <td width="8%" align="center"><a href="?open=Account-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
      </tr>

<?php } ?> 
   
    </table></td>
  </tr>
  <tr>
    <td width="309"><strong>Jumlah Data : </strong>  <?php echo $jumlah; ?>  </td>
    <td width="373" align="right"><strong>Halaman Ke : </strong>

	<?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Account-Data&hal=$h'>$h</a> ";
	}
	?> 

</td>
  </tr>
</table>
</body>
</html>

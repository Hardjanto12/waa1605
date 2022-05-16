<?php
// Koneksi database
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php"; 

# TOMBOL CARI
if(isset($_POST['btnCari'])) {
	$txtKataKunci	= $_POST['txtKataKunci'];
	$filterSQL 		= "WHERE name LIKE '%$txtKataKunci%' OR msn like '%$txtKataKunci%'";
}
else {
	$filterSQL 	= "";
}

// Variabel pada form cari
$dataKataKunci	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';

// Untuk pembagian halaman data (Paging)
$baris	= 50;
$hal 	= isset($_GET['hal']) ? $_GET['hal'] : 1;

$infoSql= "SELECT * FROM prj $filterSQL";
$infoQry= sqlsrv_query($koneksidb , $infoSql) ;
$jumlah	= sqlsrv_num_rows($infoQry);
$maks	= ceil($jumlah/$baris); 
$mulai	= $baris * ($hal-1);
?>
<html>
<head>
<title>Data Proyek</title>
</head>
<body>

<table class="table-common" width="910" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td colspan="2"><strong>
    <h1>DATA PROYEK </h1>
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
        <td><strong>Kode. / Nama Proyek </strong></td>
        <td>:</td>
        <td><input name="txtKataKunci" type="text" id="txtKataKunci" value="<?php echo $dataKataKunci; ?>" size="40" maxlength="100">
          <input name="btnCari" type="submit" id="btnCari" value="Cari"></td>
      </tr>
    </table>
  </form>
	
	</td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?open=Proyek-Add" target="_self"><img src="images/btn_add_data.png" width="140" height="34" border="0"></a></td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="3%" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="11%" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="35%" bgcolor="#CCCCCC"><strong>Nama</strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
	  
<?php
// Skrip menampilkan data Nasabah
$mySql 	= "SELECT * FROM prj $filterSQL ORDER BY prj ASC ";
$myQry 	= sqlsrv_query($koneksidb,$mySql) ;
$nomor  = $mulai; 
while ($myData = sqlsrv_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['prj'];
?>	

      <tr>
        <td> <?php echo $nomor; ?> </td>
        <td> <?php echo $myData['prj']; ?> </td>
        <td> <?php echo $myData['name']; ?> </td>
        <td width="9%" align="center"><a href="?open=Proyek-Delete&Kode=<?php echo $Kode; ?>" target="_self" 
			onclick="return confirm('YAKIN INGIN MENGHAPUS DATA BAGIAN INI ... ?')">Delete</a></td>
        <td width="12%" align="center"><a href="?open=Proyek-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
      </tr>

<?php } ?> 
   
    </table></td>
  </tr>
  <tr>
    <td width="309"><strong>Jumlah Data : </strong>  <?php echo $jumlah; ?>  </td>
    <td width="373" align="right"><strong>Halaman Ke : </strong>

	<?php
	for ($h = 1; $h <= $maks; $h++) {
		echo " <a href='?open=Proyek-Data&hal=$h'>$h</a> ";
	}
	?> 

</td>
  </tr>
</table>
</body>
</html>

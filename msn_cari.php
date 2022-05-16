<?php
//session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
//include_once "library/inc.seslogin.php"; 
	
# PENCARIAN DATA
$pencarianSQL	= "";
 
if(isset($_POST['btnCari'])) {
	$txtKataKunci	= trim($_POST['txtKataKunci']);

	// Pencarian Multi String (beberapa kata)
	$keyWord 		= explode(" ", $txtKataKunci);
	$pencarianSQL	= "";
	if(count($keyWord) > 1) {
		foreach($keyWord as $kata) {
			$pencarianSQL	.= " OR name LIKE'%$kata%'";
		}
	}
	
	// Menyusun sub query pencarian
	$pencarianSQL	= "WHERE msn='$txtKataKunci' OR name LIKE '%$txtKataKunci%' ".$pencarianSQL;
}

# Simpan Variabel  
$keyWord		= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
$dataKataKunci 	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : $keyWord;

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM msn $pencarianSQL";
$pageQry 	= sqlsrv_query($koneksidb, $pageSql );
$jmlData	= sqlsrv_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pencarian Mesin</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css"></head>
<body>
<h1> PENCARIAN MESIN </h1>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list" width="800" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td width="114" bgcolor="#CCCCCC"><strong>PENCARIAN</strong></td>
      <td width="6">&nbsp;</td>
      <td width="654">&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Cari No./ Nama </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKataKunci" type="text" id="txtKataKunci" value="<?php echo $dataKataKunci; ?>" size="40" maxlength="80">
      <input name="btnCari" type="submit" id="btnCari" value="Cari"></td>
    </tr>
  </table>
</form>

<table class="table-list" width="800" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="26" bgcolor="#CCCCCC"><strong>No.</strong></td>
    <td width="103" bgcolor="#CCCCCC"><strong>Kode Mesin </strong></td>
    <td width="338" bgcolor="#CCCCCC"><strong>Nama Mesin </strong></td>
  </tr>
  
<?php
// Skrip menampilkan data dari database
$mySql = "SELECT * FROM msn $pencarianSQL ORDER BY msn ASC ";
$myQry = sqlsrv_query($koneksidb, $mySql);
$nomor  = 0; 
while ($myData = sqlsrv_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['msn'];
	
	// gradasi warna
	if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
?>

  <tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo $myData['msn']; ?> </td>
    <td> <?php echo $myData['name']; ?> </td>
    <td> 
	<a href="#" onClick="window.opener.document.getElementById('txtMsn').value = '<?php echo $myData['msn']; ?>';
						 window.close();"> <b>Pilih </b> </a>  </td>
  </tr>

<?php } ?>

  <tr>
    <td colspan="3"><strong>Jumlah Data : </strong> <?php echo $jmlData; ?> </td>
    <td colspan="3" align="right"><strong>Halaman Ke : </strong> 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='msn_cari.php?hal=$list[$h]&keyWord=$dataKataKunci'>$h</a> ";
	}
	?>
	</td>
  </tr>
</table>
</body>
</html>
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
	$pencarianSQL	= "WHERE inv='$txtKataKunci' OR name LIKE '%$txtKataKunci%' ".$pencarianSQL;
}

# Simpan Variabel  
$keyWord		= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
$dataKataKunci 	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : $keyWord;

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM inv $pencarianSQL";
$pageQry 	= sqlsrv_query($koneksidb, $pageSql );
$jmlData	= sqlsrv_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pencarian COA</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css"></head>
<body>
<h1> PENCARIAN INVENTORY </h1>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list" width="800" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td width="114" bgcolor="#CCCCCC"><strong>PENCARIAN</strong></td>
      <td width="6">&nbsp;</td>
      <td width="654">&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Cari Kode./ Nama </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKataKunci" type="text" id="txtKataKunci" value="<?php echo $dataKataKunci; ?>" size="40" maxlength="80">
      <input name="btnCari" type="submit" id="btnCari" value="Cari"></td>
    </tr>
  </table>
</form>

<table class="table-list" width="800" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="25" bgcolor="#CCCCCC"><strong>No.</strong></td>
    <td width="140" bgcolor="#CCCCCC"><strong>Kode Inventory </strong></td>
    <td width="288" bgcolor="#CCCCCC"><strong>Nama Inventory </strong></td>
    <td width="184" bgcolor="#CCCCCC"><strong>Unit</strong></td>
    <td width="65" bgcolor="#CCCCCC"><strong>Harga Beli </strong></td>
    <td width="65" bgcolor="#CCCCCC"><strong>Harga Jual </strong></td>
    <td width="48" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  
<?php
// Skrip menampilkan data dari database
$mySql = "SELECT * FROM inv $pencarianSQL ORDER BY inv ASC ";
$myQry = sqlsrv_query($koneksidb, $mySql);
$nomor  = 0; 
while ($myData = sqlsrv_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['inv'];
	
	// gradasi warna
	if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
?>

  <tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo $myData['inv']; ?> </td>
    <td> <?php echo $myData['name']; ?> </td>
    <td> <?php echo $myData['unit']; ?> </td>
    <td align="right"> <?php echo format_angka($myData['bprice']); ?> </td>
    <td align="right"> <?php echo format_angka($myData['price1']); ?> </td>
    <td> 
	<a href="#" onClick="window.opener.document.getElementById('txtInv').value = '<?php echo $myData['inv']; ?>';
						 window.opener.document.getElementById('txtNamaInv').value = '<?php echo $myData['name']; ?>';
						 window.close();"> <b>Pilih </b> </a>  </td>
  </tr>

<?php } ?>

  <tr>
    <td colspan="3"><strong>Jumlah Data : </strong> <?php echo $jmlData; ?> </td>
    <td colspan="3" align="right"><strong>Halaman Ke : </strong> 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='inv_cari.php?hal=$list[$h]&keyWord=$dataKataKunci'>$h</a> ";
	}
	?>
	</td>
  </tr>
</table>
</body>
</html>
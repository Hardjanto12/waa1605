<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";

# Baca noNota dari URL
if(isset($_GET['Kode'])){
	$Kode = $_GET['Kode'];
	
	// Perintah untuk mendapatkan data dari tabel simpanan
	$mySql = "select a.nojnl, convert(varchar,a.date,111) as tgl, a.sub, c.name as namasub, a.remark, a.ppn, a.chuser, a.chtime, b.inv, d.name as namainv, b.qty, b.price, b.val, b.dtseq, case when a.ppn='1' then 'NON PPN' when a.ppn='2' then 'INCLUDE' else 'EXCLUDE' end as sppn from klr a inner join kld b on a.nojnl=b.nojnl inner join sub c on a.sub=c.sub inner join inv d on b.inv=d.inv WHERE a.nojnl='$Kode'";
	$myQry 	= sqlsrv_query($koneksidb,$mySql) ;
	$myData= sqlsrv_fetch_array($myQry);
}
else {
	echo "Nomor Simpanan (Kode) tidak ditemukan";
	exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cetak Pembelian</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body >
<table class="table-list"  width="700" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="155"><strong>No. Penjualan </strong></td>
    <td width="10"><strong>:</strong></td>
    <td width="540"> <?php echo $myData['nojnl']; ?> </td>
  </tr>
  <tr>
    <td><strong>Tgl. Penjualan </strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo IndonesiaTgl($myData['tgl']); ?> </td>
  </tr>
  <tr>
    <td><strong>Customer </strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo $myData['namasub']; ?> </td>
  </tr>
  <tr>
    <td><strong>PPN</strong></td>
    <td><strong>:</strong></td>
    <td> <?php echo $myData['sppn']; ?> </td>
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
    <td width="56" bgcolor="#CCCCCC"><strong>Gudang </strong></td>
    <td width="109" bgcolor="#CCCCCC"><strong>Kode Barang </strong></td>
    <td width="157" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td width="48" align="right" bgcolor="#CCCCCC"><strong>Qty</strong></td>
    <td width="96" align="right" bgcolor="#CCCCCC"><strong>Harga(Rp)</strong></td>
    <td width="60" align="right" bgcolor="#CCCCCC"><strong>Disc(Rp)</strong></td>
    <td width="88" align="right" bgcolor="#CCCCCC"><strong>Total(Rp) </strong></td>
  </tr>
  
<?php
# SKRIP TAMPILKAN DATA 
// Variabel
$total	= 0;

  // Skrip menampilkan data Simpanan
	$mySql = "select a.nojnl, convert(varchar,a.date,111) as tgl, a.sub, c.name as namasub, a.remark, a.ppn, a.chuser, a.chtime, b.inv, d.name as namainv, b.acc, b.qty, b.price, b.disc, b.val, b.dtseq, case when a.ppn='1' then 'NON PPN' when a.ppn='2' then 'INCLUDE' else 'EXCLUDE' end as sppn from klr a inner join kld b on a.nojnl=b.nojnl inner join sub c on a.sub=c.sub inner join inv d on b.inv=d.inv WHERE a.nojnl='$Kode' order by dtseq";
	$myQry 	= sqlsrv_query($koneksidb,$mySql) ;
$nomor = 0; 
$dpp = 0; 
$ppn = 0; 
while ($myData = sqlsrv_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['nojnl'];
	if ($myData['ppn']==2){
		$dpp = $dpp + ($myData['val']*100/111);
		$ppn = $ppn + ($myData['val']*100/111*11/100);
	} elseif ($myData['ppn']==3) {
		$dpp = $dpp + ($myData['val']);
		$ppn = $ppn + ($myData['val']*11/100);
	} else {
		$dpp = $dpp + ($myData['val']);
		$ppn = $ppn + 0;
	}
	$total	= $total + ($myData['val'] );
?>
<tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo $myData['acc']; ?> </td>
    <td> <?php echo $myData['inv']; ?> </td>
    <td> <?php echo $myData['namainv']; ?> </td>
    <td align="right"> <?php echo format_angka($myData['qty']); ?> </td>
    <td align="right"> <?php echo format_angka($myData['price']); ?> </td>
    <td align="right"> <?php echo format_angka($myData['disc']); ?> </td>
    <td align="right"> <?php echo format_angka($myData['val']); ?> </td>
  </tr>
  
<?php  } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="56" bgcolor="#CCCCCC"><div align="right" class="style1"> DPP : </div></td>
      <td width="56" bgcolor="#CCCCCC"><div align="right" class="style1"> <?php echo format_angka($dpp); ?></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="56" bgcolor="#CCCCCC"><div align="right" class="style1"> PPN : </div></td>
      <td width="56" bgcolor="#CCCCCC"><div align="right" class="style1"> <?php echo format_angka($ppn); ?></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="56" bgcolor="#CCCCCC"><div align="right" class="style1"> TOTAL : </div></td>
      <td width="56" bgcolor="#CCCCCC"><div align="right" class="style1"> <?php echo format_angka($dpp+$ppn); ?></div></td>
    </tr>

</table>
</body>
</html>

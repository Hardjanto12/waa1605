<?php
include_once "library/inc.seslogin.php"; 
include_once "library/inc.connection.php";
include_once "library/inc.library.php"; 


// Membaca User yang Login
$userLogin	= $_SESSION['SES_LOGIN'];

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	// Baca variabel data form
	$txtKodeNas			= $_POST['txtNomor'];
	$txtSub				= $_POST['txtSub'];
	$txtInv				= $_POST['txtInv'];
//	$txtNamaInv			= $_POST['txtNamaInv'];
	$txtQty				= $_POST['txtQty'];
	$txtPrice			= $_POST['txtPrice'];
	$txtKeterangan		= $_POST['txtKeterangan'];
	$txtTanggal 		= InggrisTgl($_POST['txtTanggal']);
 
   # Validasi Form Input 
	// Validasi Form Input
	$pesanError = array();
	if (trim($txtSub)=="") {
		$pesanError[] = "Data <b>Kode Supplier</b> tidak boleh kosong !";		
	}
	if (trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, silahkan pilih pada kalender !";		
	}
	$mySql	= "select COUNT(*) as jml from msd where nojnl='" . trim($txtKodeNas) . "' ";
	$myQry = sqlsrv_query( $koneksidb, $mySql);
	$myData= sqlsrv_fetch_array($myQry);
	if($myData['jml']==0) {
		$pesanError[] = "Detail Kosong!";		
	}
			
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		$noJurnal 	= $txtKodeNas;
		$mySql	= "delete from msk where nojnl='$txtKodeNas'";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$mySql	= "INSERT INTO msk (nojnl, date, acc, sub, remark, val, disc, vdisc, ppn, grup, chtime, chuser,control,nprint) VALUES ('$noJurnal','$txtTanggal','301','$txtSub','$txtKeterangan',0,0,0,'1','1',getdate(),'$userLogin','1',1)";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
 		$mySql	= "insert into msd select * from msdtmp where nojnl='$txtKodeNas' ";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
 		$mySql	= "delete from msktmp where nojnl='$txtKodeNas' ";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
 		$mySql	= "delete from msdtmp where nojnl='$txtKodeNas' ";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?open=Pembelian-Data'>";
		exit;	
		
	}	
}


if(isset($_POST['btnTambahkan'])){
	# Baca Data dari Form Input
	$txtKodeNas			= $_POST['txtNomor'];
	$txtSub				= $_POST['txtSub'];
	$txtInv				= $_POST['txtInv'];
//	$txtNamaInv			= $_POST['txtNamaInv'];
	$txtQty				= $_POST['txtQty'];
	$txtPrice			= $_POST['txtPrice'];
	$txtKeterangan		= $_POST['txtKeterangan'];
	$txtTanggal 		= InggrisTgl($_POST['txtTanggal']);
 
   # Validasi Form Input 
	// Validasi Form Input
	$pesanError = array();
	if (trim($txtSub)=="") {
		$pesanError[] = "Data <b>Kode Supplier</b> tidak boleh kosong !";		
	}
	if (trim($txtInv)=="") {
		$pesanError[] = "Data <b>Kode Voucher</b> tidak boleh kosong !";		
	}
	if (trim($txtQty)=="" or ! is_numeric(trim($txtQty))) {
	$pesanError[] = "Data <b>Qty </b> masih kosong, harus diisi angka !";
	}
	if (trim($txtPrice)=="" or ! is_numeric(trim($txtPrice))) {
	$pesanError[] = "Data <b>Harga </b> masih kosong, harus diisi angka !";
	}

	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		// Skrip simpan data ke database
	$mySql	= "select count(*) as jml from msktmp where nojnl='" . trim($txtKodeNas) . "' ";
//	echo $mySql;
	$myQry = sqlsrv_query( $koneksidb, $mySql);
	$myData= sqlsrv_fetch_array($myQry);
	if($myData['jml']==0) {
		$mySql	= "INSERT INTO msktmp (nojnl, date, acc, sub, remark, val, disc, vdisc, ppn, grup, chtime, chuser,control,nprint) VALUES ('$txtKodeNas','$txtTanggal','301','$txtSub','$txtKeterangan',0,0,0,'1','1',getdate(),'$userLogin','6',1)";
//		echo $mySql;
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
	} else {
		$mySql	= "delete from msktmp where nojnl='$txtKodeNas'";
//		echo $mySql;
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$mySql	= "INSERT INTO msktmp (nojnl, date, acc, sub, remark, val, disc, vdisc, ppn, grup, chtime, chuser,control,nprint) VALUES ('$txtKodeNas','$txtTanggal','301','$txtSub','$txtKeterangan',0,0,0,'1','1',getdate(),'$userLogin','1',1)";
//		echo $mySql;
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
	}

		$mySql	= "INSERT INTO msdtmp (nojnl, acc, inv, ref, remark, qty, price, val, disc, Vdisc, grup, dtseq) VALUES ('$txtKodeNas','','$txtInv','',(select name from inv where inv='$txtInv'),'$txtQty','$txtPrice',$txtQty*$txtPrice,0,0,'1',(select isnull(MAX(dtseq),0) from msd where nojnl='$txtKodeNas')+1)";
//		echo $mySql;
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}


		echo "<meta http-equiv='refresh' content='0; url=?open=Pembelian-Edit&Kode=$txtKodeNas&Tanda=0'>";
		exit;	
	}
}

# VARIABEL DATA DARI & UNTUK FORM
//$Kode 	= isset($_GET['Kode']) ? $_GET['Kode'] : $_POST['txtNomor'];
$Kode	 = $_GET['Kode']; 
$Tanda	 = $_GET['Tanda']; 
$noTransaksi 	= $userLogin;
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataSub		= isset($_POST['txtSub']) ? $_POST['txtSub'] : '';
$dataNamaSub		= isset($_POST['txtNamaSub']) ? $_POST['txtNamaSub'] : '';
$dataInv		= isset($_POST['txtInv']) ? $_POST['txtInv'] : '';
$dataNamaInv		= isset($_POST['txtNamaInv']) ? $_POST['txtNamaInv'] : '';
$dataQty	= isset($_POST['txtQty']) ? $_POST['txtQty'] : '0';
$dataPrice	= isset($_POST['txtPrice']) ? $_POST['txtPrice'] : '0';

?>

<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<style type="text/css">
<!--
.style1 {
	color: #000000;
	font-weight: bold;
}
-->
</style>
 

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<h1>Pembelian Edit </h1>
  <table width="800" cellspacing="1"  class="table-list">

<?php
// Skrip menampilkan data Transaksi Pinjaman
if ($Tanda=="1") {
		$mySql	= "delete from msktmp where nojnl='$Kode'";
//		echo $mySql;
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$mySql	= "delete from msdtmp where nojnl='$Kode'";
//		echo $mySql;
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$mySql	= "insert into msktmp select * from msk where nojnl='$Kode'";
//		echo $mySql;
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$mySql	= "insert into msdtmp select * from msd where nojnl='$Kode'";
//		echo $mySql;
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
}
$mySql 	= "SELECT a.*, b.name, convert(varchar,a.date,111) as tgl FROM msktmp a left outer join sub b on a.sub=b.sub  where a.nojnl='$Kode'  ";
//echo $mySql;
$myQry 	= sqlsrv_query($koneksidb,$mySql) ;
$nom  = 0; 
$myData= sqlsrv_fetch_array($myQry);
if($myData['nojnl']<>"") {
	$nom++;
	$Kode = $myData['nojnl'];
?>

    <tr>
      <td bgcolor="#CCCCCC"><strong>HEADER</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="19%"><strong>No. Jurnal </strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="80%"><input name="txtNomor" value="<?php echo $Kode; ?>" size="23" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Tgl.  Jurnal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo IndonesiaTgl($myData['tgl']); ?>" size="23" maxlength="23" /></td>
    </tr>
    <tr>
      <td><strong>Supplier</strong></td>
      <td><strong>:</strong></td>
       <td><input name="txtSub" id="txtSub" size="20" maxlength="6" value="<?php echo $myData['sub']; ?>" onchange="javascript:submitform();" />
<a href="sub_cari.php"
   onclick="window.open(this.href,'targetWindow',
                                   `toolbar=no,
                                    location=no,
                                    status=no,
                                    menubar=no,
                                    scrollbars=yes,
                                    resizable=yes,
                                    width=SomeSize,
                                    height=SomeSize`);
 return false;">Cari</a>    
 	</tr>
    <tr>
      <td><strong>Nama Supplier </strong></td>
      <td><strong>:</strong></td>
      <td><input  type="text" size="80" id="txtNamaSub"   maxlength="100" value="<?php echo $myData['name']; ?>" disabled="disabled"/></td>
    </tr>
    <tr>
      <td><strong> Keterangan </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeterangan" value="<?php echo $myData['remark']; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></td>
    </tr>
<?php  }  ?>
    <tr>
      <td bgcolor="#CCCCCC"><strong>DETAIL</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Kode Barang</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtInv" id="txtInv" size="20" maxlength="6" value="<?php echo $dataInv; ?>" onchange="javascript:submitform();" />
<a href="inv_cari.php"
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
      <td><strong>Nama Barang </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNamaInv" type="text" size="80" id="txtNamaInv"   maxlength="100" value="<?php echo $dataNamaInv; ?>" disabled="disabled"/></td>
    </tr>
	<tr>
      <td><strong> Qty </strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <input align="right" name="txtQty" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $dataQty; ?>" size="20" maxlength="12"/>
      </b></td>
    </tr>
	<tr>
      <td><strong> Harga </strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <input align="right" name="txtPrice" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $dataPrice ?>" size="20" maxlength="12"/>
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTambahkan" type="submit" id="btnTambahkan" style="cursor:pointer;" value="TAMBAHKAN" /></td>
    </tr>
  </table>
  <table width="799" border="0">
    <tr>
      <td width="59" bgcolor="#CCCCCC"><div align="center" class="style1">No.</div></td>
      <td width="132" bgcolor="#CCCCCC"><div align="center" class="style1">Voucher</div></td>
      <td width="417" bgcolor="#CCCCCC"><div align="center" class="style1">Description</div></td>
      <td width="113" bgcolor="#CCCCCC"><div align="center" class="style1">Qty</div></td>
      <td width="113" bgcolor="#CCCCCC"><div align="center" class="style1">Harga</div></td>
      <td width="113" bgcolor="#CCCCCC"><div align="center" class="style1">Total</div></td>
      <td width="56" bgcolor="#CCCCCC"><div align="center" class="style1">Tools</div></td>
    </tr>
<?php
// Skrip menampilkan data Transaksi Pinjaman
$mySql 	= "SELECT a.* FROM msdtmp a inner join inv b on a.inv=b.inv where a.nojnl='$Kode' ORDER BY a.nojnl, a.dtseq ASC ";
//echo $mySql;
$myQry 	= sqlsrv_query($koneksidb,$mySql) ;
$nomor  = 0; 
$ttl = 0;
while ($myData = sqlsrv_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['nojnl'];
	$Seq = $myData['dtseq'];
	$ttl = $ttl + $myData['val'];
?>
    <tr>
      <td align="center"><?php echo $myData['dtseq']; ?></td>
      <td><?php echo $myData['inv']; ?></td>
      <td><?php echo $myData['remark']; ?></td>
      <td align="right"> <?php echo format_angka($myData['qty']); ?></td>
      <td align="right"> <?php echo format_angka($myData['price']); ?></td>
      <td align="right"> <?php echo format_angka($myData['val']); ?></td>
	  <td width="56" align="center"><a href="?open=Pembelian-Delete-Detail-Edit&Kode=<?php echo $Kode; ?>&Seq=<?php echo $Seq; ?>" target="_self">Delete</a></td>
    </tr>
<?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="56" bgcolor="#CCCCCC"><div align="right" class="style1"> <?php echo format_angka($ttl); ?></div></td>
    </tr>
  </table>
  <br>
</form>
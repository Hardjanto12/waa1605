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
	$txtInv				= $_POST['txtInv'];
	$txtPrj				= $_POST['txtPrj'];
	$txtMsn				= $_POST['txtMsn'];
	$txtTab				= $_POST['txtTab'];
//	$txtNamaInv			= $_POST['txtNamaInv'];
	$txtQty				= $_POST['txtQty'];
	$txtKeterangan		= $_POST['txtKeterangan'];
	$txtTanggal 		= InggrisTgl($_POST['txtTanggal']);
 
   # Validasi Form Input 
	// Validasi Form Input
	$pesanError = array();
	if (trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, silahkan pilih pada kalender !";		
	}
	$mySql	= "select COUNT(*) as jml from pbd where nojnl='" . trim($txtKodeNas) . "' ";
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
		$noJurnal 	= buatKodeJurnal("pbh", "PMK","nojnl",9,$koneksidb,trim($txtTanggal));
//		echo $noJurnal;
		$mySql	= "delete from pbh where nojnl='" .$txtKodeNas. "'";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$mySql	= "INSERT INTO pbh (nojnl, date, remark, grup, chtime, chuser,chtime2, chuser2,control,nprint) VALUES ('$noJurnal','$txtTanggal','$txtKeterangan','1',getdate(),'$userLogin','','','7',1)";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
//		echo $noJurnal;
 		$mySql	= "update pbd set nojnl='$noJurnal' where nojnl='$txtKodeNas' ";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
 		$mySql	= "delete from pbd where nojnl='$txtKodeNas' ";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?open=Pemakaian-Data'>";
		exit;	
		
	}	
}

# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnKosong'])){
	// Baca variabel data form
	$txtKodeNas			= $_POST['txtNomor'];
	// Skrip Validasi form
 		$mySql	= "delete from pbd where nojnl='$txtKodeNas' ";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$my2Sql	= "delete from pbh where nojnl='$txtKodeNas' ";				
		$stmt2 = sqlsrv_query($koneksidb,$my2Sql);	
		if( $stmt2 === false ) {
			die( print_r( sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?open=Pemakaian-Add'>";
		exit;	
		
 		# SIMPAN KE DATABASE
		// Jika jumlah error pesanError tidak ada, maka proses Penyimpanan akan dikalkukan
		
		
}

if(isset($_POST['btnTambahkan'])){
	# Baca Data dari Form Input
	$txtKodeNas			= $_POST['txtNomor'];
	$txtInv				= $_POST['txtInv'];
	$txtPrj				= $_POST['txtPrj'];
	$txtMsn				= $_POST['txtMsn'];
	$txtTab				= $_POST['txtTab'];
//	$txtNamaInv			= $_POST['txtNamaInv'];
	$txtQty				= $_POST['txtQty'];
	$txtKeterangan		= $_POST['txtKeterangan'];
	$txtTanggal 		= InggrisTgl($_POST['txtTanggal']);
   # Validasi Form Input 
	// Validasi Form Input
	$pesanError = array();
	if (trim($txtTab)=="") {
		$pesanError[] = "Data <b>Kode Gudang</b> tidak boleh kosong !";		
	}
	if (trim($txtInv)=="") {
		$pesanError[] = "Data <b>Kode Voucher</b> tidak boleh kosong !";		
	}
	if (trim($txtQty)=="" or ! is_numeric(trim($txtQty))) {
	$pesanError[] = "Data <b>Qty </b> masih kosong, harus diisi angka !";
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
	$mySql	= "select count(*) as jml from pbh where nojnl='" . trim($txtKodeNas) . "' ";
	$myQry = sqlsrv_query( $koneksidb, $mySql);
	$myData= sqlsrv_fetch_array($myQry);
	if($myData['jml']==0) {
		$mySql	= "INSERT INTO pbh (nojnl, date, remark, grup, chtime, chuser,chtime2, chuser2,control,nprint) VALUES ('$txtKodeNas','$txtTanggal','$txtKeterangan','1',getdate(),'$userLogin','','','6',1)";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
	} else {
		$mySql	= "delete from pbh where nojnl='". trim($txtKodeNas) ."'";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$mySql	= "INSERT INTO pbh (nojnl, date, remark, grup, chtime, chuser,chtime2, chuser2,control,nprint) VALUES ('$txtKodeNas','$txtTanggal','$txtKeterangan','1',getdate(),'$userLogin','','','6',1)";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
	}

		$mySql	= "INSERT INTO pbd (nojnl, acc, prj, msn, inv, ref, remark, qty, grup, dtseq,stt) VALUES ('$txtKodeNas','$txtTab','$txtPrj','$txtMsn','$txtInv','',(select name from inv where inv='$txtInv'),'$txtQty','1',(select isnull(MAX(dtseq),0) from pbd where nojnl='$txtKodeNas')+1,'1')";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}


		echo "<meta http-equiv='refresh' content='0; url=?open=Pemakaian-Add'>";
		exit;	
	}
}

# VARIABEL DATA DARI & UNTUK FORM
$noTransaksi 	= $userLogin;
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataMsn		= isset($_POST['txtMsn']) ? $_POST['txtMsn'] : '';
$dataPrj		= isset($_POST['txtPrj']) ? $_POST['txtPrj'] : '';
$dataTab		= isset($_POST['txtTab']) ? $_POST['txtTab'] : '';
$dataInv		= isset($_POST['txtInv']) ? $_POST['txtInv'] : '';
$dataNamaInv		= isset($_POST['txtNamaInv']) ? $_POST['txtNamaInv'] : '';
$dataQty	= isset($_POST['txtQty']) ? $_POST['txtQty'] : '0';
$dataPrice	= isset($_POST['txtPrice']) ? $_POST['txtPrice'] : '0';
$dataDisc	= isset($_POST['txtDisc']) ? $_POST['txtDisc'] : '0';
$datappn			= isset($_POST['cmbppn']) ? $_POST['cmbppn'] : '1';
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
<h1>Pemakaian Bahan Baru </h1>
  <table width="800" cellspacing="1"  class="table-list">

<?php
// Skrip menampilkan data Transaksi Pinjaman
$mySql 	= "SELECT a.*,  convert(varchar,a.date,111) as tgl FROM pbh a  where a.nojnl='$userLogin'  ";
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
      <td width="80%"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Tgl.  Jurnal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo IndonesiaTgl($myData['tgl']); ?>" size="23" maxlength="23" /></td>
    </tr>
    <tr>
      <td><strong> Keterangan </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeterangan" value="<?php echo $myData['remark']; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><input name="btnKosong" type="submit" id="btnKosong" style="cursor:pointer;" value="KOSONGKAN TRANSAKSI" /></td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></td>
    </tr>
<?php } else { ?>
    <tr>
      <td bgcolor="#CCCCCC"><strong>HEADER</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="19%"><strong>No. Jurnal </strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="80%"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Tgl.  Jurnal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="23" maxlength="23" /></td>
    </tr>
    <tr>
      <td><strong> Keterangan </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><input name="btnKosong" type="submit" id="btnKosong" style="cursor:pointer;" value="KOSONGKAN TRANSAKSI" /></td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></td>
    </tr>
<?php } ?>
    <tr>
      <td bgcolor="#CCCCCC"><strong>DETAIL</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Proyek</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtPrj" id="txtPrj" size="20" maxlength="15" value="<?php echo $dataPrj; ?>" onchange="javascript:submitform();" />
<a href="prj_cari.php"
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
      <td><strong>Mesin</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtMsn" id="txtMsn" size="20" maxlength="15" value="<?php echo $dataMsn; ?>" onchange="javascript:submitform();" />
<a href="msn_cari.php"
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
      <td><strong>Gudang</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTab" id="txtTab" size="20" maxlength="15" value="<?php echo $dataTab; ?>" onchange="javascript:submitform();" />
<a href="tab_cari.php"
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
      <td><strong>Kode Barang</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtInv" id="txtInv" size="20" maxlength="15" value="<?php echo $dataInv; ?>" onchange="javascript:submitform();" />
<a href="inv_cari2.php"
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
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTambahkan" type="submit" id="btnTambahkan" style="cursor:pointer;" value="TAMBAHKAN" /></td>
    </tr>
  </table>
  <table width="799" border="0">
    <tr>
      <td width="59" bgcolor="#CCCCCC"><div align="left" class="style1">No.</div></td>
      <td width="132" bgcolor="#CCCCCC"><div align="left" class="style1">Proyek</div></td>
      <td width="132" bgcolor="#CCCCCC"><div align="left" class="style1">Mesin</div></td>
      <td width="132" bgcolor="#CCCCCC"><div align="left" class="style1">Gudang</div></td>
      <td width="132" bgcolor="#CCCCCC"><div align="left" class="style1">Kode</div></td>
      <td width="417" bgcolor="#CCCCCC"><div align="left" class="style1">Description</div></td>
      <td width="113" bgcolor="#CCCCCC"><div align="right" class="style1">Qty</div></td>
      <td width="56" bgcolor="#CCCCCC"><div align="center" class="style1">Tools</div></td>
    </tr>
<?php
// Skrip menampilkan data Transaksi Pinjaman
$mySql 	= "SELECT a.*, b.name as namainv FROM pbd a inner join inv b on a.inv=b.inv where a.nojnl='$userLogin' ORDER BY a.nojnl, a.dtseq ASC ";
//echo $mySql;
$myQry 	= sqlsrv_query($koneksidb,$mySql) ;
$nomor  = 0; 
$jml  = 0; 
while ($myData = sqlsrv_fetch_array($myQry)) {
	$nomor++;
	$Kode = $myData['nojnl'];
	$Seq = $myData['dtseq'];
	$jml = $jml + $myData['qty'];
?>
    <tr>
      <td align="center"><?php echo $myData['dtseq']; ?></td>
      <td><?php echo $myData['prj']; ?></td>
      <td><?php echo $myData['msn']; ?></td>
      <td><?php echo $myData['acc']; ?></td>
      <td><?php echo $myData['inv']; ?></td>
      <td><?php echo $myData['remark']; ?></td>
      <td align="right"> <?php echo format_angka($myData['qty']); ?></td>
	  <td width="56" align="center"><a href="?open=Pemakaian-Delete-Detail&Kode=<?php echo $Kode; ?>&Seq=<?php echo $Seq; ?>" target="_self">Delete</a></td>
    </tr>
<?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="56" bgcolor="#CCCCCC"><div align="right" class="style1"> <?php echo format_angka($jml); ?></div></td>
    </tr>
  </table>
  <br>
</form>
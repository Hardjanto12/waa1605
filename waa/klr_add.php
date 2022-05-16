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
	$txtTab				= $_POST['txtTab'];
	$txtInv				= $_POST['txtInv'];
//	$txtNamaInv			= $_POST['txtNamaInv'];
	$txtQty				= $_POST['txtQty'];
	$txtPrice			= $_POST['txtPrice'];
	$txtDisc			= $_POST['txtDisc'];
	$txtKeterangan		= $_POST['txtKeterangan'];
	$txtTanggal 		= InggrisTgl($_POST['txtTanggal']);
	$cmbppn				= $_POST['cmbppn'];
 
   # Validasi Form Input 
	// Validasi Form Input
	$pesanError = array();
	if (trim($txtSub)=="") {
		$pesanError[] = "Data <b>Kode Supplier</b> tidak boleh kosong !";		
	}
	if (trim($cmbppn)=="Kosong") {
		$pesanError[] = "Data <b>PPN</b> tidak boleh kosong !";		
	}
	if (trim($txtTanggal)=="--") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, silahkan pilih pada kalender !";		
	}
	if (trim($cmbppn)=="NON PPN" ) {
	$jppn = "1";
	} elseif (trim($cmbppn)=="INCLUDE" ) {
	$jppn = "2";
	} elseif (trim($cmbppn)=="EXCLUDE" ) {
	$jppn = "3";
	}
	$mySql	= "select COUNT(*) as jml from kld where nojnl='" . trim($txtKodeNas) . "' ";
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
		$noJurnal 	= buatKodeJurnal("klr", "PJL","nojnl",9,$koneksidb,trim($txtTanggal));
//		echo $noJurnal;
		$mySql	= "delete from klr where nojnl='" .$txtKodeNas. "'";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$mySql	= "INSERT INTO klr (nojnl, date, acc, sub, remark, val, disc, vdisc, ppn, grup, chtime, chuser,control,nprint) VALUES ('$noJurnal','$txtTanggal','301','$txtSub','$txtKeterangan',0,0,0,'$jppn','1',getdate(),'$userLogin','1',1)";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
//		echo $noJurnal;
 		$mySql	= "update kld set nojnl='$noJurnal' where nojnl='$txtKodeNas' ";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
 		$mySql	= "delete from kld where nojnl='$txtKodeNas' ";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?open=Penjualan-Data'>";
		exit;	
		
	}	
}

# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnKosong'])){
	// Baca variabel data form
	$txtKodeNas			= $_POST['txtNomor'];
	// Skrip Validasi form
 		$mySql	= "delete from kld where nojnl='$txtKodeNas' ";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$my2Sql	= "delete from klr where nojnl='$txtKodeNas' ";				
		$stmt2 = sqlsrv_query($koneksidb,$my2Sql);	
		if( $stmt2 === false ) {
			die( print_r( sqlsrv_errors(), true));
		}
		echo "<meta http-equiv='refresh' content='0; url=?open=Penjualan-Add'>";
		exit;	
		
 		# SIMPAN KE DATABASE
		// Jika jumlah error pesanError tidak ada, maka proses Penyimpanan akan dikalkukan
		
		
}

if(isset($_POST['btnTambahkan'])){
	# Baca Data dari Form Input
	$txtKodeNas			= $_POST['txtNomor'];
	$txtSub				= $_POST['txtSub'];
	$txtInv				= $_POST['txtInv'];
	$txtTab				= $_POST['txtTab'];
//	$txtNamaInv			= $_POST['txtNamaInv'];
	$txtQty				= $_POST['txtQty'];
	$txtPrice			= $_POST['txtPrice'];
	$txtDisc			= $_POST['txtDisc'];
	$txtKeterangan		= $_POST['txtKeterangan'];
	$txtTanggal 		= InggrisTgl($_POST['txtTanggal']);
	$cmbppn				= $_POST['cmbppn'];
	 
   # Validasi Form Input 
	// Validasi Form Input
	$pesanError = array();
	if (trim($txtSub)=="") {
		$pesanError[] = "Data <b>Kode Supplier</b> tidak boleh kosong !";		
	}
	if (trim($cmbppn)=="Kosong") {
		$pesanError[] = "Data <b>PPN</b> tidak boleh kosong !";		
	}
	if (trim($txtTab)=="") {
		$pesanError[] = "Data <b>Kode Gudang</b> tidak boleh kosong !";		
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
	if (trim($cmbppn)=="NON PPN" ) {
	$jppn = "1";
	} elseif (trim($cmbppn)=="INCLUDE" ) {
	$jppn = "2";
	} elseif (trim($cmbppn)=="EXCLUDE" ) {
	$jppn = "3";
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
	if (trim($txtDisc)=="" or ! is_numeric(trim($txtDisc))) {
	$pesanError[] = "Data <b>Disc </b> masih kosong, harus diisi angka !";
	}
	$mySql	= "select count(*) as jml from klr where nojnl='" . trim($txtKodeNas) . "' ";
	$myQry = sqlsrv_query( $koneksidb, $mySql);
	$myData= sqlsrv_fetch_array($myQry);
	if($myData['jml']==0) {
		$mySql	= "INSERT INTO klr (nojnl, date, acc, sub, remark, val, disc, vdisc, ppn, grup, chtime, chuser,control,nprint) VALUES ('$txtKodeNas','$txtTanggal','301','$txtSub','$txtKeterangan',0,0,0,'$jppn','1',getdate(),'$userLogin','6',1)";
		echo $mySql+"1";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
	} else {
		$mySql	= "delete from klr where nojnl='". trim($txtKodeNas) ."'";
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		echo $mySql+"2";
		$mySql	= "INSERT INTO klr (nojnl, date, acc, sub, remark, val, disc, vdisc, ppn, grup, chtime, chuser,control,nprint) VALUES ('$txtKodeNas','$txtTanggal','301','$txtSub','$txtKeterangan',0,0,0,'$jppn','1',getdate(),'$userLogin','6',1)";
		echo $mySql;
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}
	}

		$mySql	= "INSERT INTO kld (nojnl, acc, inv, ref, remark, qty, price, val, disc, Vdisc, grup, dtseq,stt) VALUES ('$txtKodeNas','$txtTab','$txtInv','',(select name from inv where inv='$txtInv'),'$txtQty','$txtPrice',$txtQty*($txtPrice-$txtDisc),$txtDisc,0,'1',(select isnull(MAX(dtseq),0) from kld where nojnl='$txtKodeNas')+1,'1')";
		echo $mySql;
		$stmt = sqlsrv_query( $koneksidb, $mySql);
		if( $stmt === false ) {
			 die( print_r( sqlsrv_errors(), true));
		}


		echo "<meta http-equiv='refresh' content='0; url=?open=Penjualan-Add'>";
		exit;	
	}
}

# VARIABEL DATA DARI & UNTUK FORM
$noTransaksi 	= $userLogin;
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataSub		= isset($_POST['txtSub']) ? $_POST['txtSub'] : '';
$dataNamaSub		= isset($_POST['txtNamaSub']) ? $_POST['txtNamaSub'] : '';
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
<h1>Penjualan Baru </h1>
  <table width="800" cellspacing="1"  class="table-list">

<?php
// Skrip menampilkan data Transaksi Pinjaman
$mySql 	= "SELECT a.*, b.name, convert(varchar,a.date,111) as tgl, case when a.ppn='1' then 'NON PPN' when a.ppn='2' then 'INCLUDE' else 'EXCLUDE' end as sppn FROM klr a left outer join sub b on a.sub=b.sub  where a.nojnl='$userLogin'  ";
//echo $mySql;
$myQry 	= sqlsrv_query($koneksidb,$mySql) ;
$nom  = 0; 
$myData= sqlsrv_fetch_array($myQry);
if($myData['nojnl']<>"") {
	$nom++;
	$Kode = $myData['nojnl'];
	$sppn = $myData['sppn'];
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
      <td><strong>Customer</strong></td>
      <td><strong>:</strong></td>
       <td><input name="txtSub" id="txtSub" size="20" maxlength="6" value="<?php echo $myData['sub']; ?>" onchange="javascript:submitform();" />
<a href="cus_cari.php"
   onclick="window.open(this.href,'targetWindow',
                                   `toolbar=no,
                                    location=no,
                                    status=no,
                                    menubar=no,
                                    scrollbars=yes,
                                    resizable=yes,
                                    width=SomeSize,
                                    height=SomeSize`);
 return false;">Cari</a> 	</tr>
    <tr>
      <td><strong>Nama Customer </strong></td>
      <td><strong>:</strong></td>
      <td><input  type="text" size="80" id="txtNamaSub"   maxlength="100" value="<?php echo $myData['name']; ?>" disabled="disabled"/></td>
    </tr>
    <tr>
      <td><strong>PPN</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbppn" id="cmbppn">
          <option value="Kosong">....</option>
          <?php
		  $pilihan = array("NON PPN", "INCLUDE","EXCLUDE");
		  foreach ($pilihan as  $nilai) {
			if ($sppn==$nilai) {
				$cek=" selected";
			} else { $cek = ""; }
			echo "<option value='$nilai' $cek> $nilai</option>";
		  }
		  ?>
      </select></td>
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
      <td><strong>Customer</strong></td>
      <td><strong>:</strong></td>
       <td><input name="txtSub" id="txtSub" size="20" maxlength="6" value="<?php echo $dataSub; ?>" onchange="javascript:submitform();" />
<a href="cus_cari.php"
   onclick="window.open(this.href,'targetWindow',
                                   `toolbar=no,
                                    location=no,
                                    status=no,
                                    menubar=no,
                                    scrollbars=yes,
                                    resizable=yes,
                                    width=SomeSize,
                                    height=SomeSize`);
 return false;">Cari</a> 	</tr>
    <tr>
      <td><strong>Nama Customer </strong></td>
      <td><strong>:</strong></td>
      <td><input  type="text" size="80" id="txtNamaSub"   maxlength="100" value="<?php echo $dataNamaSub; ?>" disabled="disabled"/></td>
    </tr>
    <tr>
      <td><strong>PPN</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbppn" id="cmbppn">
          <option value="Kosong">....</option>
          <?php
		  $pilihan = array("NON PPN", "INCLUDE","EXCLUDE");
		  foreach ($pilihan as  $nilai) {
			if ($datagrup==$nilai) {
				$cek=" selected";
			} else { $cek = ""; }
			echo "<option value='$nilai' $cek> $nilai</option>";
		  }
		  ?>
      </select></td>
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
      <td><strong>Gudang</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTab" id="txtTab" size="20" maxlength="6" value="<?php echo $dataTab; ?>" onchange="javascript:submitform();" />
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
      <td><input name="txtInv" id="txtInv" size="20" maxlength="6" value="<?php echo $dataInv; ?>" onchange="javascript:submitform();" />
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
    </tr>
	<tr>
      <td><strong> Harga </strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <input align="right" name="txtPrice" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $dataPrice ?>" size="20" maxlength="12"/>
      </b></td>
    </tr>
	<tr>
      <td><strong> Disc </strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <input align="right" name="txtDisc" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $dataDisc ?>" size="20" maxlength="12"/>
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
      <td width="59" bgcolor="#CCCCCC"><div align="left" class="style1">No.</div></td>
      <td width="132" bgcolor="#CCCCCC"><div align="left" class="style1">Gudang</div></td>
      <td width="132" bgcolor="#CCCCCC"><div align="left" class="style1">Kode</div></td>
      <td width="417" bgcolor="#CCCCCC"><div align="left" class="style1">Description</div></td>
      <td width="113" bgcolor="#CCCCCC"><div align="right" class="style1">Qty</div></td>
      <td width="113" bgcolor="#CCCCCC"><div align="right" class="style1">Harga</div></td>
      <td width="113" bgcolor="#CCCCCC"><div align="right" class="style1">Disc</div></td>
      <td width="113" bgcolor="#CCCCCC"><div align="right" class="style1">Total</div></td>
      <td width="56" bgcolor="#CCCCCC"><div align="center" class="style1">Tools</div></td>
    </tr>
<?php
// Skrip menampilkan data Transaksi Pinjaman
$mySql 	= "SELECT a.* FROM kld a inner join inv b on a.inv=b.inv where a.nojnl='$userLogin' ORDER BY a.nojnl, a.dtseq ASC ";
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
      <td><?php echo $myData['acc']; ?></td>
      <td><?php echo $myData['inv']; ?></td>
      <td><?php echo $myData['remark']; ?></td>
      <td align="right"> <?php echo format_angka($myData['qty']); ?></td>
      <td align="right"> <?php echo format_angka($myData['price']); ?></td>
      <td align="right"> <?php echo format_angka($myData['disc']); ?></td>
      <td align="right"> <?php echo format_angka($myData['val']); ?></td>
	  <td width="56" align="center"><a href="?open=Pembelian-Delete-Detail&Kode=<?php echo $Kode; ?>&Seq=<?php echo $Seq; ?>" target="_self">Delete</a></td>
    </tr>
<?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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
<?php
# KONTROL MENU PROGRAM
if(isset($_GET['open'])) {
	// Jika mendapatkan variabel URL ?open
	switch($_GET['open']){	

		case '' :
			if(!file_exists ("info.php")) die ("File tidak ada !"); 
			include "info.php";	break;
			
		case 'Halaman-Utama' :
			if(!file_exists ("info.php")) die ("File tidak ada !"); 
			include "info.php";	break;
		
		# KONTROL PROGRAM LOGIN
		case 'Login' :
			if(!file_exists ("login.php")) die ("File tidak ada !"); 
			include "login.php"; break;
			
		case 'Login-Validasi' :
			if(!file_exists ("login_validasi.php")) die ("File tidak ada !"); 
			include "login_validasi.php"; break;
			
		case 'Logout' :
			if(!file_exists ("login_out.php")) die ("File tidak ada !"); 
			include "login_out.php"; break;		

		# KONTROL PROGRAM MANAJEMEN DATA CUSTOMER
		case 'Account-Data' :
			if(!file_exists ("acc_data.php")) die ("File tidak ada !"); 
			include "acc_data.php";	 break;		
		case 'Account-Add' :
			if(!file_exists ("acc_add.php")) die ("File tidak ada !"); 
			include "acc_add.php";	 break;		
		case 'Account-Delete' :
			if(!file_exists ("acc_delete.php")) die ("File tidak ada !"); 
			include "acc_delete.php";	 break;		
		case 'Account-Edit' :
			if(!file_exists ("acc_edit.php")) die ("File tidak ada !"); 
			include "acc_edit.php";	 break;		

		case 'Supplier-Data' :
			if(!file_exists ("sub_data.php")) die ("File tidak ada !"); 
			include "sub_data.php";	 break;		
		case 'Supplier-Add' :
			if(!file_exists ("sub_add.php")) die ("File tidak ada !"); 
			include "sub_add.php";	 break;		
		case 'Supplier-Edit' :
			if(!file_exists ("sub_edit.php")) die ("File tidak ada !"); 
			include "sub_edit.php";	 break;		
		case 'Supplier-Delete' :
			if(!file_exists ("sub_delete.php")) die ("File tidak ada !"); 
			include "sub_delete.php";	 break;		

		case 'Customer-Data' :
			if(!file_exists ("cus_data.php")) die ("File tidak ada !"); 
			include "cus_data.php";	 break;		
		case 'Customer-Add' :
			if(!file_exists ("cus_add.php")) die ("File tidak ada !"); 
			include "cus_add.php";	 break;		
		case 'Customer-Edit' :
			if(!file_exists ("cus_edit.php")) die ("File tidak ada !"); 
			include "cus_edit.php";	 break;		
		case 'Customer-Delete' :
			if(!file_exists ("cus_delete.php")) die ("File tidak ada !"); 
			include "cus_delete.php";	 break;		

		case 'Mesin-Data' :
			if(!file_exists ("msn_data.php")) die ("File tidak ada !"); 
			include "msn_data.php";	 break;		
		case 'Mesin-Add' :
			if(!file_exists ("msn_add.php")) die ("File tidak ada !"); 
			include "msn_add.php";	 break;		
		case 'Mesin-Edit' :
			if(!file_exists ("msn_edit.php")) die ("File tidak ada !"); 
			include "msn_edit.php";	 break;		
		case 'Mesin-Delete' :
			if(!file_exists ("msn_delete.php")) die ("File tidak ada !"); 
			include "msn_delete.php";	 break;		

		case 'Proyek-Data' :
			if(!file_exists ("prj_data.php")) die ("File tidak ada !"); 
			include "prj_data.php";	 break;		
		case 'Proyek-Add' :
			if(!file_exists ("prj_add.php")) die ("File tidak ada !"); 
			include "prj_add.php";	 break;		
		case 'Proyek-Edit' :
			if(!file_exists ("prj_edit.php")) die ("File tidak ada !"); 
			include "prj_edit.php";	 break;		
		case 'Proyek-Delete' :
			if(!file_exists ("prj_delete.php")) die ("File tidak ada !"); 
			include "prj_delete.php";	 break;		

		case 'Inventory-Data' :
			if(!file_exists ("inv_data.php")) die ("File tidak ada !"); 
			include "inv_data.php";	 break;		
		case 'Inventory-Add' :
			if(!file_exists ("inv_add.php")) die ("File tidak ada !"); 
			include "inv_add.php";	 break;		
		case 'Inventory-Edit' :
			if(!file_exists ("inv_edit.php")) die ("File tidak ada !"); 
			include "inv_edit.php";	 break;		
		case 'Inventory-Delete' :
			if(!file_exists ("inv_delete.php")) die ("File tidak ada !"); 
			include "inv_delete.php";	 break;		

		case 'Dept-Data' :
			if(!file_exists ("dep_data.php")) die ("File tidak ada !"); 
			include "dep_data.php";	 break;		
		case 'Dept-Add' :
			if(!file_exists ("dep_add.php")) die ("File tidak ada !"); 
			include "dep_add.php";	 break;		
		case 'Dept-Edit' :
			if(!file_exists ("dep_edit.php")) die ("File tidak ada !"); 
			include "dep_edit.php";	 break;		
		case 'Dept-Delete' :
			if(!file_exists ("dep_delete.php")) die ("File tidak ada !"); 
			include "dep_delete.php";	 break;		

		case 'Pembelian-Data' :
			if(!file_exists ("msk_data.php")) die ("File tidak ada !"); 
			include "msk_data.php";	 break;		
		case 'Pembelian-Add' :
			if(!file_exists ("msk_add.php")) die ("File tidak ada !"); 
			include "msk_add.php";	 break;		
		case 'Pembelian-Edit' :
			if(!file_exists ("msk_edit.php")) die ("File tidak ada !"); 
			include "msk_edit.php";	 break;		
		case 'Pembelian-Delete' :
			if(!file_exists ("msk_delete.php")) die ("File tidak ada !"); 
			include "msk_delete.php";	 break;		
		case 'Pembelian-Delete-Detail' :
			if(!file_exists ("msk_deletedetail.php")) die ("File tidak ada !"); 
			include "msk_deletedetail.php";	 break;		
		case 'Pembelian-Delete-Detail-Edit' :
			if(!file_exists ("msk_deletedetailedit.php")) die ("File tidak ada !"); 
			include "msk_deletedetailedit.php";	 break;		
		case 'Pembelian-Cetak' :
			if(!file_exists ("msk_cetak.php")) die ("File tidak ada !"); 
			include "msk_cetak.php";	 break;		

		case 'Penjualan-Data' :
			if(!file_exists ("klr_data.php")) die ("File tidak ada !"); 
			include "klr_data.php";	 break;		
		case 'Penjualan-Add' :
			if(!file_exists ("klr_add.php")) die ("File tidak ada !"); 
			include "klr_add.php";	 break;		
		case 'Penjualan-Edit' :
			if(!file_exists ("klr_edit.php")) die ("File tidak ada !"); 
			include "klr_edit.php";	 break;		
		case 'Penjualan-Delete' :
			if(!file_exists ("klr_delete.php")) die ("File tidak ada !"); 
			include "klr_delete.php";	 break;		
		case 'Penjualan-Delete-Detail' :
			if(!file_exists ("klr_deletedetail.php")) die ("File tidak ada !"); 
			include "klr_deletedetail.php";	 break;		
		case 'Penjualan-Delete-Detail-Edit' :
			if(!file_exists ("klr_deletedetailedit.php")) die ("File tidak ada !"); 
			include "klr_deletedetailedit.php";	 break;		
		case 'Penjualan-Cetak' :
			if(!file_exists ("klr_cetak.php")) die ("File tidak ada !"); 
			include "klr_cetak.php";	 break;		

		case 'Pemakaian-Data' :
			if(!file_exists ("pbh_data.php")) die ("File tidak ada !"); 
			include "pbh_data.php";	 break;		
		case 'Pemakaian-Add' :
			if(!file_exists ("pbh_add.php")) die ("File tidak ada !"); 
			include "pbh_add.php";	 break;		
		case 'Pemakaian-Edit' :
			if(!file_exists ("pbh_edit.php")) die ("File tidak ada !"); 
			include "pbh_edit.php";	 break;		
		case 'Pemakaian-Delete' :
			if(!file_exists ("pbh_delete.php")) die ("File tidak ada !"); 
			include "pbh_delete.php";	 break;		
		case 'Pemakaian-Delete-Detail' :
			if(!file_exists ("pbh_deletedetail.php")) die ("File tidak ada !"); 
			include "pbh_deletedetail.php";	 break;		
		case 'Pemakaian-Delete-Detail-Edit' :
			if(!file_exists ("pbh_deletedetailedit.php")) die ("File tidak ada !"); 
			include "pbh_deletedetailedit.php";	 break;		
		case 'Pemakaian-Cetak' :
			if(!file_exists ("pbh_cetak.php")) die ("File tidak ada !"); 
			include "pbh_cetak.php";	 break;		

		case 'Pemakaian-Data2' :
			if(!file_exists ("pbh2_data.php")) die ("File tidak ada !"); 
			include "pbh2_data.php";	 break;		
		case 'Pemakaian-Approve' :
			if(!file_exists ("pbh_approve.php")) die ("File tidak ada !"); 
			include "pbh_approve.php";	 break;		
		case 'Pemakaian-Reject' :
			if(!file_exists ("pbh_reject.php")) die ("File tidak ada !"); 
			include "pbh_reject.php";	 break;		

		case 'Produksi-Data' :
			if(!file_exists ("hsl_data.php")) die ("File tidak ada !"); 
			include "hsl_data.php";	 break;		
		case 'Produksi-Add' :
			if(!file_exists ("hsl_add.php")) die ("File tidak ada !"); 
			include "hsl_add.php";	 break;		
		case 'Produksi-Edit' :
			if(!file_exists ("hsl_edit.php")) die ("File tidak ada !"); 
			include "hsl_edit.php";	 break;		
		case 'Produksi-Delete' :
			if(!file_exists ("hsl_delete.php")) die ("File tidak ada !"); 
			include "hsl_delete.php";	 break;		
		case 'Produksi-Delete-Detail' :
			if(!file_exists ("hsl_deletedetail.php")) die ("File tidak ada !"); 
			include "hsl_deletedetail.php";	 break;		
		case 'Produksi-Delete-Detail-Edit' :
			if(!file_exists ("hsl_deletedetailedit.php")) die ("File tidak ada !"); 
			include "hsl_deletedetailedit.php";	 break;		
		case 'Produksi-Cetak' :
			if(!file_exists ("hsl_cetak.php")) die ("File tidak ada !"); 
			include "hsl_cetak.php";	 break;		

		case 'BiayaOverhead-Data' :
			if(!file_exists ("boh_data.php")) die ("File tidak ada !"); 
			include "boh_data.php";	 break;		
		case 'BiayaOverhead-Add' :
			if(!file_exists ("boh_add.php")) die ("File tidak ada !"); 
			include "boh_add.php";	 break;		
		case 'BiayaOverhead-Edit' :
			if(!file_exists ("boh_edit.php")) die ("File tidak ada !"); 
			include "boh_edit.php";	 break;		
		case 'BiayaOverhead-Delete' :
			if(!file_exists ("boh_delete.php")) die ("File tidak ada !"); 
			include "boh_delete.php";	 break;		
		case 'BiayaOverhead-Delete-Detail' :
			if(!file_exists ("boh_deletedetail.php")) die ("File tidak ada !"); 
			include "boh_deletedetail.php";	 break;		
		case 'BiayaOverhead-Delete-Detail-Edit' :
			if(!file_exists ("boh_deletedetailedit.php")) die ("File tidak ada !"); 
			include "boh_deletedetailedit.php";	 break;		
		case 'BiayaOverhead-Cetak' :
			if(!file_exists ("boh_cetak.php")) die ("File tidak ada !"); 
			include "boh_cetak.php";	 break;		
		
		//Laporan
		case 'Laporan-Pembelian' :
			if(!file_exists ("rpt_mskdetail.php")) die ("File tidak ada !"); 
			include "rpt_mskdetail.php";	 break;		
		case 'Laporan-Penjualan' :
			if(!file_exists ("rpt_klrdetail.php")) die ("File tidak ada !"); 
			include "rpt_klrdetail.php";	 break;		
		case 'Laporan-Pemakaian' :
			if(!file_exists ("rpt_pbhdetail.php")) die ("File tidak ada !"); 
			include "rpt_pbhdetail.php";	 break;		
		case 'Laporan-Produksi' :
			if(!file_exists ("rpt_hsldetail.php")) die ("File tidak ada !"); 
			include "rpt_hsldetail.php";	 break;		
		case 'Laporan-Overhead' :
			if(!file_exists ("rpt_bohdetail.php")) die ("File tidak ada !"); 
			include "rpt_bohdetail.php";	 break;		
		case 'Laporan-HPP' :
			if(!file_exists ("rpt_hppdetail.php")) die ("File tidak ada !"); 
			include "rpt_hppdetail.php";	 break;		
		case 'Laporan-Stock' :
			if(!file_exists ("rpt_acpdetail.php")) die ("File tidak ada !"); 
			include "rpt_acpdetail.php";	 break;		


		case 'Ubah-Password' :
			if(!file_exists ("ubahpassword.php")) die ("File tidak ada !"); 
			include "ubahpassword.php";	 break;		
		case 'UbahPassword-Validasi' :
			if(!file_exists ("ubahpassword_validasi.php")) die ("File tidak ada !"); 
			include "ubahpassword_validasi.php"; break;

	}
}
else {
	// Jika tidak mendapatkan variabel URL : ?open
	if(!file_exists ("info.php")) die ("File tidak ada !"); 
	include "info.php";	
}
?>
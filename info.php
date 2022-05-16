<?php
if(isset($_SESSION['SES_LOGIN'])) {
	echo "<h3>Selamat datang di ENTERTECH System  - @copyright 2022</h3>";
//	echo "<b> Anda login sebagai Admin";
	exit;
}
else {
	echo "<h3>Selamat datang di ENTERTECH System  - @copyright 2022</h3>";
	echo "<h3>Please Login!</h3>";
	//echo "<b>Anda belum login, silahkan <a href='?open=Login' alt='Login'>login </a>untuk mengakses sitem ini ";	
}
?> 

<?php
# Konek ke Web Server Lokal
$serverName = "202.78.202.237,8888"; 
$connectionInfo = array( "Database"=>"tmp3", "UID"=>"sa", "PWD"=>"P@ssw0rd123");
$koneksidb = sqlsrv_connect( $serverName, $connectionInfo);

if( $koneksidb ) {
//     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}	 
?>
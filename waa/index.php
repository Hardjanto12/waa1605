<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";
include_once "library/inc.tanggal.php";

// Baca Jam pada Komputer
date_default_timezone_set("Asia/Jakarta");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Entertech</title>

<link type="text/css" rel="stylesheet" href="styles/style.css">

<link type="text/css" rel="stylesheet" href="plugins/tigra_calendar/tcal.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="tableExport/tableExport.js"></script>
<script type="text/javascript" src="tableExport/jquery.base64.js"></script>
<script src="js/export.js"></script>
<script type="text/javascript" src="plugins/tigra_calendar/tcal.js"></script> 


<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" type="text/css" href="plugins/tigra_calendar/tcal.css">

<script type="text/javascript" src="plugins/tigra_calendar/tcal.js"></script> 
<script type="text/javascript" src="plugins/js.popupWindow.js"></script>

<style type="text/css">
<!--
.style2 {
	font-size: 36px;
	font-weight: bold;
}
-->
</style>
</head>
<div id="wrap">
<body>
<table width="100%" class="table-main">
  <tr>
    <td height="50" colspan="2"><div id="header">
      <p class="style2">ENTERTECH</p>
    </div></td>
  </tr>
  <tr valign="top">
    <td width="15%"  style="border-right:5px solid #DDDDDD;"><div style="margin:5px; padding:5px;"><?php include "menu.php"; ?></div></td>
    <td width="69%" height="550"><div style="margin:5px; padding:5px;"><?php include "buka_file.php";?></div></td>
  </tr>
</table>
</body>
</div>
</html>

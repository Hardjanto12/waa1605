<?php
//session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
//include_once "library/inc.seslogin.php"; 
	
// pagination
$p = $_GET["p"];
// $p 	= isset($_GET['p']) ? $_GET['p'] : 1;


if (is_null($p)){
  $_GET["p"] = 1;
echo "<meta http-equiv='refresh' content='0; url=acc_cari.php?p=1'>";
}


# PENCARIAN DATA
$pencarianSQL	= "";
 
if(isset($_POST['btnCari'])) {
	$txtKataKunci	= trim($_POST['txtKataKunci']);

	// Pencarian Multi String (beberapa kata)
	$keyWord 		= explode(" ", $txtKataKunci);
	$pencarianSQL	= "";
	if(count($keyWord) > 1) {
		foreach($keyWord as $kata) {
			$pencarianSQL	.= " OR nmac LIKE'%$kata%'";
		}
	}
	
	// Menyusun sub query pencarian
	$pencarianSQL	= "WHERE kdac='$txtKataKunci' OR nmac LIKE '%$txtKataKunci%' ".$pencarianSQL;
}

# Simpan Variabel  
$keyWord		= isset($_GET['keyWord']) ? $_GET['keyWord'] : '';
$dataKataKunci 	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : $keyWord;

// pagination start
// Limit data per page
$limitdata = 50;

/* It's for counting the rows. */
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $koneksidb, "SELECT * FROM acc" , $params, $options );

$row_count = sqlsrv_num_rows( $stmt );


$jumlahpage = ceil($row_count/$limitdata);



$rowakhir = $p * $limitdata;
// $rowawal = $rowakhir - 9;
$rowawal	= $limitdata *   ($p-1);

$datapagepbh = "WITH
            tbl_acc
            AS
            (
                SELECT ROW_NUMBER() OVER (
                          ORDER BY 
                                  kdac ASC
                          ) row_num, *
                          from acc
                          $keyWord
            )
        SELECT
            *
        FROM
            tbl_acc
        WHERE 
                      row_num >= $rowawal AND
            row_num <= $rowakhir;
              ;";

// # UNTUK PAGING (PEMBAGIAN HALAMAN)
// $baris 		= 50;
// $halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
// $pageSql 	= "SELECT * FROM acc $pencarianSQL";
// $pageQry 	= sqlsrv_query($koneksidb, $pageSql );
// $jmlData	= sqlsrv_num_rows($pageQry);
// $maksData	= ceil($jmlData/$baris);
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Pencarian COA</title>
    <!-- <link href="../styles/style.css" rel="stylesheet" type="text/css"> -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <h1 class="display-5">PENCARIAN ACCOUNT</h1>
    </div>
    <div class="container-fluid">
        <!-- search box -->
        <div class="row">
            <div class="col-2 mb-3">
                <strong>PENCARIAN</strong>
            </div>
        </div>
        <div class="row">
            <div class="col-2 mx-0">
                <strong>Cari No./ Nama</strong>
            </div>
            <div class="col-4 mr-5">
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="txtKataKunci" class="sr-only">Cari</label>
                        <input type="text" class="form-control" id="txtKataKunci" name="txtKataKunci"
                            placeholder="Cari...">
                    </div>
            </div>
            <div class="col">
                <button type="submit" name="btnCari" id="btnCari" class="btn btn-primary mb-2">Cari</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <table class="table table-bordered text-center table-hover mx-auto">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Kode Account</th>
                    <th>Nama Account</th>
                    <th>DK</th>
                    <th>Grup</th>
                    <th>Tools</th>
                </tr>
            </thead>
            <?php
// Skrip menampilkan data dari database
// $mySql = "SELECT * FROM acc $pencarianSQL ORDER BY kdac ASC ";
$myQry = sqlsrv_query($koneksidb, $datapagepbh);
while ($myData = sqlsrv_fetch_array($myQry)) {
  
  $nomor  = $myData['row_num']; 
	$Kode = $myData['kdac'];
	
	// gradasi warna
	if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
?>

            <tr>
                <td> <?php echo $myData['row_num']; ?> </td>
                <td> <?php echo $myData['kdac']; ?> </td>
                <td> <?php echo $myData['nmac']; ?> </td>
                <td> <?php echo $myData['dk']; ?> </td>
                <td> <?php echo $myData['grup']; ?> </td>
                <td>
                    <a href="#" onClick="window.opener.document.getElementById('txtAcc').value = '<?php echo $myData['kdac']; ?>';
						 window.close();"> <b>Pilih </b> </a>
                </td>
            </tr>

            <?php } ?>

            <tr>
                <td><strong>Jumlah Data : </strong> <?php echo $row_count; ?>
                </td>
                <td colspan="3" align="right">
                    <div class="col d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            <!-- /* It's a pagination. */ -->
                            <ul class="pagination">
                                <?php 

                        $prev = $_GET["p"] - 1;
                        $nxt = $_GET["p"] + 1;

                        $nxtoff = "";
                        $prevoff = "";
                        
                        if ($nxt > $jumlahpage) {
                            $nxtoff = "disabled";
                        }
                        if ($_GET["p"] == 1) {
                            $prevoff = "disabled";
                        }
                        

                        echo '<li class="page-item '. $prevoff .'"><a class="page-link" href="?open=Account-Data&p='.$prev.'">Previous</a></li>';


                        for ($x = 1; $x <= $jumlahpage; $x+=1) {
                            $active = ""; 
                            if ($_GET["p"] == $x) {
                                $active = "active";
                            }            
                            echo '<li class="page-item '.$active.'"><a class="page-link" href="?open=Account-Data&p='.$x.'">';
                        echo "$x";
                        echo'</a></li>';
                        }
                        echo '<li class="page-item '. $nxtoff .'"><a class="page-link" href="?open=Account-Data&p='. $nxt .'">Next</a></li>';?>
                            </ul>
                        </nav>
                        <!-- end pagination -->
                    </div>
                </td>
            </tr>
        </table>
    </div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</body>

</html>
<?php
// Koneksi database
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php"; 



// pagination
// $p = $_GET["p"];
$p 	= isset($_GET['p']) ? $_GET['p'] : 1;


// if ($p = 1){
//   $_GET["p"] = 1;
// echo "<meta http-equiv='refresh' content='0; url=?open=Account-Data&p=1'>";
// }

# TOMBOL CARI
if(isset($_POST['btnCari'])) {
	$txtKataKunci	= $_POST['txtKataKunci'];
	$filterSQL 		= "WHERE nmac LIKE '%$txtKataKunci%' OR kdac like '%$txtKataKunci%'";
}
else {
	$filterSQL 	= "";
}

// Variabel pada form cari
$dataKataKunci	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';


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

/* It's a query for pagination. */
$datapageacc = "WITH
            tbl_acc
            AS
            (
                SELECT ROW_NUMBER() OVER (
                          ORDER BY 
                                  kdac ASC
                          ) row_num, *
                          from acc
                          $filterSQL
            )
        SELECT
            *
        FROM
            tbl_acc
        WHERE 
                      row_num >= $rowawal AND
            row_num <= $rowakhir;
              ;";




 ?>
<html>

<head>
    <title>Data COA</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="container-fluid">
        <h1 class=" display-3">Data COA</h1>
    </div>

    <div class="container">
        <!-- search -->
        <div class="row mt-3d-flex align-items-center">
            <!-- search box -->
            <div class="col-2">
                <div class="row">
                    <strong>PENCARIAN</strong>
                </div>
                <div class="row">
                    <strong>Kode. / Nama COA </strong>
                </div>
            </div>
            <div class="col-3">
                <form action=" <?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
                    <label for="txtKataKunci" class="sr-only">Cari</label>
                    <input class="form-control" name="txtKataKunci" type="text" id="txtKataKunci"
                        value="<?php echo $dataKataKunci; ?>" placeholder="Cari">
            </div>
            <div class="col">
                <input name="btnCari" type="submit" id="btnCari" value="Cari" class="btn btn-primary mb-2">
                </form>
            </div>
            <!-- button add data -->
            <div class="col-auto mb-3">
                <a href="?open=Account-Add" target="_self">
                    <button class="btn btn-primary btn-lg"><i class="fa fa-plus"></i>
                        Add Data</button>
                </a>
            </div>
        </div>
    </div>


    <!-- Table -->
    <div class="container ">
        <table class="table table-bordered text-center table-hover mx-auto">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Induk</th>
                    <th>DK</th>
                    <th>Detil</th>
                    <th>Grup</th>
                    <th>Tools</th>
                </tr>
            </thead>
            <?php
                            // Skrip menampilkan data
                // $mySql 	= "SELECT * FROM acc $filterSQL ORDER BY kdac ASC ";
                // $myQry 	= sqlsrv_query($koneksidb,$mySql) ;
                $myQry = sqlsrv_query($koneksidb, $datapageacc);
                while ($myData = sqlsrv_fetch_array($myQry)) {
                  $nomor  = $myData['row_num']; 
	            // $nomor++;
	            $Kode = $myData['kdac'];?>
            <tr>
                <td width="3%"> <?php echo $nomor; ?> </td>
                <td> <?php echo $myData['kdac']; ?> </td>
                <td> <?php echo $myData['nmac']; ?> </td>
                <td> <?php echo $myData['induk']; ?> </td>
                <td> <?php echo $myData['dk']; ?> </td>
                <td> <?php echo $myData['detil']; ?> </td>
                <td> <?php echo $myData['grup']; ?> </td>
                <td width="20%">
                    <a href="?open=Account-Delete&Kode=<?php echo $Kode; ?>" target="_self"><button type="button"
                            class="btn btn-danger">Delete</button></a>
                    <a href="?open=Account-Edit&Kode=<?php echo $Kode; ?>" target="_self"><button type="button"
                            class="btn btn-warning">Edit</button>
                    </a>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td><strong>Jumlah Data : </strong> <?php echo $row_count; ?>
                </td>
            </tr>
            <tr>

            </tr>
        </table>
    </div>
    <!-- end of table -->

    <div class="row">
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
    </div>

</body>

</html>
<?php
    session_start();
    if(!isset($_SESSION['departemen'])){
        header('Location:index.php');
    }
    if(isset($_POST['btnKeluar'])){
        session_destroy();
        header('Location:index.php');
    }

    include( "Connection.php" );
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Form Tag Postingan</title>
        <link rel="shortcut icon" href="img/Logo Argantari.png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- fullCalendar -->
        <link rel="stylesheet" href="plugins/fullcalendar/main.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-1.5.1.min.js"></script>
        <script src="https://kit.fontawesome.com/ec0d9dcac4.js" crossorigin="anonymous"></script>
        
    </head>
    <body style="background-color: rgb(240, 240, 240);">
        <div class="container-fluid">
            <div class="row" style="background-color: dimgrey; padding-top: 10px; padding-bottom: 10px; padding-right: 20px;">
                <ul class="form-inline my-2 my-lg-0 mr-auto">
                    <a href="admin.php"><button name="btnBack" class="btn btn-primary my-2 my-sm-0" type="submit">Kembali</button></a>
                </ul>
            </div>
            <br>
            <h3 align="center" style="font-family: Arial, Helvetica, sans-serif;">List Tag Departemen</h3>
            <div class="table-responsive-sm" style="padding-left: 5%; padding-right: 5%;">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col">No</th>
                        <th scope="col">Departemen</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col" style="width:20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT *, DATEDIFF(CURDATE(),tanggal) AS 'beda' FROM tag ORDER BY tanggal DESC";
                            $query = $dbConn->prepare($sql);
                            $query->execute();
                            $no = 1;
                            while ($row = $query->fetch(PDO::FETCH_ASSOC) ) {
                        ?>
                        <tr>
                        <th scope="row"><?php echo $no; ?></th>
                        <td><?php echo $row['departemen'];?></td>
                        <td><?php echo $row['tanggal'];?></td>
                        <td><?php echo $row['waktu'];?></td>
                        <td>
                        <?php
                            if(strcmp($row['keterangan'],"Aman") == 0){
                                echo "<span class=\"badge badge-success\">".$row['keterangan']."</span>";
                            } else {
                                echo "<span class=\"badge badge-danger\">".$row['keterangan']."</span>";
                            }
                        ?>
                        </td>
                        <td>
                        <?php
                            if($row['beda'] <= 0){
                        ?>
                        <a href="admin_edit.php?id=<?php echo $row['id'];?>"><i class="far fa-edit btn btn-primary"></i></a>&nbsp;
                        <a href="admin.php?id=<?php echo $row['id'];?>" onClick="return confirm('Anda yakin untuk menghapus data tanggal <?php echo $row['tanggal']." ".$row['waktu']." hari";?>?')"><i class="far fa-trash-alt btn btn-danger"></i></a>
                        <?php } ?>
                        </td>
                        </tr>
                        <?php
                            $no++;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery UI -->
        <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
        
    </body>
</html>
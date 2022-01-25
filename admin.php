<?php
    session_start();
    if(isset($_SESSION['departemen'])){
        if(strcmp($_SESSION['departemen'],"admin") == 1) header('Location:index.php');
    }
    if(!isset($_SESSION['departemen'])){
        header('Location:index.php');
    }
    if(isset($_POST['btnKeluar'])){
        session_destroy();
        header('Location:index.php');
    }

    include( "Connection.php" );

    if(isset($_POST['btnEdit'])){
        $departemen = $_POST['inputDepartemen'];
        $tanggal = date("Y-m-d", strtotime($_POST['inputTanggal']));
        $waktu = $_POST['inputWaktu'];
        $id = $_POST['id'];
        $id_waktu;
        if(strcmp("Pagi", $waktu) == 0) $id_waktu = 1;
        else if(strcmp("Siang", $waktu) == 0) $id_waktu = 2;
        else if(strcmp("Sore", $waktu) == 0)$id_waktu = 3;
        else $id_waktu = 4;

        $dateExplode = $_POST['inputTanggal'];
        $keterangan = $_POST['inputKeterangan'];
        
        try {
            $sql = "UPDATE tag SET departemen = :departemen, waktu = :waktu, tanggal = :tanggal,id_waktu = :id_waktu, keterangan = :keterangan WHERE id = :id";
            $query = $dbConn->prepare($sql);
            $query->bindparam(':departemen', $departemen);
            $query->bindparam(':waktu', $waktu);
            $query->bindparam(':tanggal', $tanggal);
            $query->bindparam(':id_waktu', $id_waktu);
            $query->bindparam(':keterangan',$keterangan);
            $query->bindparam(':id', $id);
            $query->execute();

            echo "<script>alert('Data Tag berhasil diubah');window.location='admin.php';</script>";
        } catch (\Throwable $th) {
            echo "<script>alert('".$th."');window.location='admin.php';</script>";
        }
    }

    if(isset($_GET['id'])){
        try {
            $sql = "DELETE FROM tag WHERE id = :id";
            $query = $dbConn->prepare($sql);
            $query->bindparam(':id', $_GET['id']);
            $query->execute();

            echo "<script>alert('Data Tag berhasil dihapus');window.location='admin.php';</script>";
        } catch (\Throwable $th) {
            echo "<script>alert('".$th."');window.location='admin.php';</script>";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Data Admin</title>
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
                <ul class="form-inline my-2 my-lg-0 ml-auto">
                       <a href="admin_list.php"><button name="btnEdit" class="btn btn-primary my-2 my-sm-0" type="submit">Edit Tag</button></a>
                    &nbsp;&nbsp;
                        <a href="kalendar.php"><button name="btnEdit" class="btn btn-primary my-2 my-sm-0" type="submit">Lihat Kalendar</button></a>
                    &nbsp;&nbsp;
                    <form method="POST" action="form.php">
                        <button name="btnKeluar" class="btn btn-danger my-2 my-sm-0" type="submit" onClick="return confirm('Anda yakin untuk keluar?')">Keluar</button>
                    </form>
                </ul>
            </div>
            <br>
            <div class="card text-white bg-info mb-3" style="max-width: 18rem; margin-left: 5%; ">
                <div class="card-header">Today Post (<?php echo date("l, j F Y",time());?>)</div>
                    <div class="card-body">
                        <?php
                            $sql = "SELECT * FROM tag WHERE tanggal = curdate() ORDER BY id_waktu";
                            $query = $dbConn->prepare($sql);
                            $query->execute();
                            while ($row = $query->fetch(PDO::FETCH_ASSOC) ) {
                        ?>
                        <p class="card-text"><?php echo $row['departemen']." - ".$row['waktu'];?></p>
                        <?php }?>
                    </div>
                </div>
            </div>
            <h3 align="center" style="font-family: Arial, Helvetica, sans-serif;">Data Log Tag Departemen</h3>
            <div class="table-responsive-sm" style="padding-left: 5%; padding-right: 5%;">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col">No</th>
                        <th scope="col">Departemen</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col" style="width:20%;">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM log ORDER BY timestamp DESC LIMIT 25";
                            $query = $dbConn->prepare($sql);
                            $query->execute();
                            $no = 1;
                            while ($row = $query->fetch(PDO::FETCH_ASSOC) ) {
                        ?>
                        <tr>
                        <th scope="row"><?php echo $no; ?></th>
                        <td><?php echo $row['departemen'];?></td>
                        <td><?php echo $row['aksi'];?></td>
                        <td><?php echo $row['timestamp'];?></td>
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
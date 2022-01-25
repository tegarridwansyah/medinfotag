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
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        try {
            $sql = "SELECT * FROM tag WHERE id = ".$id;
            $query = $dbConn->prepare($sql);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            echo "<script>location.reload();</script>";
        }
        
    }
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
        
    </head>
    <body style="background-color: rgb(240, 240, 240);">
        <div class="container-fluid">
            <div class="row" style="background-color: dimgrey; padding-top: 10px; padding-bottom: 10px; padding-right: 20px;">
                <ul class="form-inline my-2 my-lg-0 mr-auto">
                    <a href="tag_list.php"><button name="btnBack" class="btn btn-primary my-2 my-sm-0" type="submit">Kembali</button></a>
                </ul>
            </div>
            <br>
            <form method="POST" action="form.php" style="padding-left: 5%; padding-right: 5%;">
                <h3 align="center">Edit Tag</h3>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Departemen</label>
                    <div class="col-sm-10">
                        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                        <input name="inputDepartemen" type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $_SESSION['departemen'];?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input name="inputTanggal" type="date" class="form-control" id="staticEmail" value="<?php echo $row['tanggal'];?>" require>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Waktu</label>
                    <div class="col-sm-10">
                        <select name="inputWaktu" class="form-control" id="exampleFormControlSelect1">
                            <option value="Pagi" <?php if(strcmp($row['waktu'],"Pagi") == 0) echo "selected"?>>Pagi</option>
                            <option value="Siang" <?php if(strcmp($row['waktu'],"Siang") == 0) echo "selected"?>>Siang</option>
                            <option value="Sore" <?php if(strcmp($row['waktu'],"Sore") == 0) echo "selected"?>>Sore</option>
                            <option value="Malam" <?php if(strcmp($row['waktu'],"Malam") == 0) echo "selected"?>>Malam</option>
                        </select>
                    </div>
                </div>
                <button name="btnEdit" type="submit" class="btn btn-primary" style="float: right; width: 100px;">Ubah</button><br><br>
                <div class="card-subtitle mb-2 text-muted" style="float:right;"><b>*Mohon cek kembali data Tag sebelum diubah</b></div>
            </form>
            <br><br>
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
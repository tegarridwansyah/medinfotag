<?php
    session_start();
    if(isset($_SESSION['departemen'])){
        if(strcmp($_SESSION['departemen'],"admin") == 0) header('Location:admin.php');
		else header('Location:form.php');
    }
    
    include( "Connection.php" );
    if(isset($_POST['btnLogin'])){
        $username = $_POST['inputUsername'];
        $password = $_POST['inputPassword'];
        try {
            $sql = "SELECT * FROM akun WHERE username = '" . $username . "' AND password = '" . $password . "'";
            $query = $dbConn->prepare($sql);
            $query->execute();
            while ($row = $query->fetch(PDO::FETCH_ASSOC) ) {
                $user = $row['username'];
                $pass = $row['password'];

                if ($username == $user && $password == $pass) {
                    $_SESSION['departemen'] = $row['departemen'];
                    if(strcmp($row['departemen'],"admin") == 0) header('Location:admin.php');
                    else header('Location:form.php');
                }
            }
            echo "<script>alert('Username/password salah!');window.location='index.php';</script>";
        } catch (\Throwable $th) {
            echo "<script>location.reload();</script>";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login Tag Postingan</title>
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
            <div class="row">
                <div class="col-md-12" style="padding-top: 10%;" align="center">
                    <h1 style="color: #343434; font-family: Arial, Helvetica, sans-serif;"><b>SELAMAT DATANG</b></h1>
                    <h5 style="color: #706d6d; font-family: Arial, Helvetica, sans-serif;">PJ Publikasi Departemen dan PDD Kepanitiaan/BSO</h5>
                    <h5 style="color: #706d6d; font-family: Arial, Helvetica, sans-serif;">Himatika FMIPA Unpad 2021</h5>
                </div>
            </div>
            <div class="row" style="padding-left: 15%; padding-right: 15%; margin-top: 40px;">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="card-subtitle mb-2 text-muted">Data username dan password sudah diberikan ke masing-masing PJ Publikasi Departemen dan PDD Kepanitiaan/BSO terkait</div>
                        <form method="POST" action="index.php" class="needs-validation" novalidate>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input name="inputUsername" type="text" class="form-control" id="username" placeholder="Username" required>
                                </div>
                                <div class="invalid-feedback">
                                    Mohon isi username
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                  <input name="inputPassword" type="password" class="form-control" id="inputPassword" placeholder="Password" required>
                                </div>
                                <div class="invalid-feedback">
                                    Mohon isi password
                                </div>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                <input type="checkbox" class="custom-control-input" id="customCheck1" onclick="myFunction()">
                                <label class="custom-control-label" for="customCheck1">Show Password</label>
                            </div>
                            <button name="btnLogin" type="submit" class="btn btn-primary" style="float: right; width: 100px;">Login</button>
                        </form>
                        <script>
                            // Example starter JavaScript for disabling form submissions if there are invalid fields
                            (function() {
                            'use strict';
                            window.addEventListener('load', function() {
                                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                var forms = document.getElementsByClassName('needs-validation');
                                // Loop over them and prevent submission
                                var validation = Array.prototype.filter.call(forms, function(form) {
                                form.addEventListener('submit', function(event) {
                                    if (form.checkValidity() === false) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                                });
                            }, false);
                            })();
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function myFunction() {
            var x = document.getElementById("inputPassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            }
        </script>

        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery UI -->
        <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
        <!-- fullCalendar 2.2.5 -->
        <script src="plugins/moment/moment.min.js"></script>
        <script src="plugins/fullcalendar/main.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
    </body>
</html>
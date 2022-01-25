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
    if(isset($_POST['btnTag'])){
        $departemen = $_POST['inputDepartemen'];
        $tanggal = date("Y-m-d", strtotime($_POST['inputTanggal']));
        $waktu = $_POST['inputWaktu'];
        $dateExplode = $_POST['inputTanggal'];
        $id_waktu;
        if(strcmp("Pagi", $waktu) == 0) $id_waktu = 1;
        else if(strcmp("Siang", $waktu) == 0) $id_waktu = 2;
        else if(strcmp("Sore", $waktu) == 0)$id_waktu = 3;
        else $id_waktu = 4;

        $keterangan;
        $date1 = time();
        $date2 = strtotime($dateExplode);
        $dif = round(($date2 - $date1)/(60*60*24));
        $dif++;
        if($dif < 2){
            $keterangan = "Denda";
        } else if($dif > 7){
            $keterangan = "Denda";
        } else {
            $keterangan = "Aman";
        }

        try {
            $sql1 = "SELECT COUNT(*) AS 'jumlah' FROM tag WHERE tanggal = :tanggal GROUP BY tanggal";
            $query1 = $dbConn->prepare($sql1);
            $query1->bindparam(':tanggal', $tanggal);
            $query1->execute();
            $row = $query1->fetch(PDO::FETCH_ASSOC);

            if((int)$row['jumlah'] > 4){
                echo "<script>alert('Hari yang dipilih sudah penuh (MAKSIMAL 5 Post/Hari)');window.location='form.php';</script>";
            } else {
                $sql = "INSERT INTO tag (departemen,waktu,tanggal,id_waktu,date_tag,keterangan) VALUES (:departemen,:waktu,:tanggal,:id_waktu,curdate(),:keterangan)";
                $query = $dbConn->prepare($sql);
                $query->bindparam(':departemen', $departemen);
                $query->bindparam(':waktu', $waktu);
                $query->bindparam(':tanggal', $tanggal);
                $query->bindparam(':id_waktu', $id_waktu);
                $query->bindparam(':keterangan',$keterangan);
                $query->execute();
                echo "<script>alert('Data Tag berhasil ditambahkan');window.location='form.php';</script>";
            }
        } catch (\Throwable $th) {
            echo "<script>alert('".$th."');window.location='form.php';</script>";
        }
    }

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
        $keterangan;
        $date1 = time();
        $date2 = strtotime($dateExplode);
        $dif = round(($date2 - $date1)/(60*60*24)) + 1;
        
        if($dif < 2){
            $keterangan = "Denda";
        } else if($dif > 7){
            $keterangan = "Denda";
        } else {
            $keterangan = "Aman";
        }
        
        try {
            $sql = "UPDATE tag SET departemen = :departemen, waktu = :waktu, tanggal = :tanggal,id_waktu = :id_waktu, keterangan = :keterangan WHERE id = :id";
            $query = $dbConn->prepare($sql);
            $query->bindparam(':departemen', $departemen);
            $query->bindparam(':waktu', $waktu);
            $query->bindparam(':tanggal', $dateExplode);
            $query->bindparam(':id_waktu', $id_waktu);
            $query->bindparam(':keterangan',$keterangan);
            $query->bindparam(':id', $id);
            $query->execute();

            echo "<script>alert('Data Tag berhasil diubah');window.location='form.php';</script>";
        } catch (\Throwable $th) {
            echo "<script>alert('".$th."');window.location='form.php';</script>";
        }
    }

    if(isset($_GET['id'])){
        try {
            $sql = "DELETE FROM tag WHERE id = :id";
            $query = $dbConn->prepare($sql);
            $query->bindparam(':id', $_GET['id']);
            $query->execute();

            echo "<script>alert('Data Tag berhasil dihapus');window.location='form.php';</script>";
        } catch (\Throwable $th) {
            echo "<script>alert('".$th."');window.location='form.php';</script>";
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
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link href="css/jquery-ui.css" rel="stylesheet">
        <script>
        $( function() {
            $( "#datefield" ).datepicker({ minDate: 0, maxDate: +7 });
            $("#datefield").datepicker("option", "dateFormat", "yy-mm-dd" ).val();
        } );
        </script>
        
    </head>
    <body style="background-color: rgb(240, 240, 240);">
        <div class="container-fluid">
            <div class="row" style="background-color: dimgrey; padding-top: 10px; padding-bottom: 10px; padding-right: 20px;">
                <ul class="form-inline my-2 my-lg-0 ml-auto">
                       <a href="tag_list.php"><button name="btnEdit" class="btn btn-primary my-2 my-sm-0" type="submit">Edit Tag</button></a>
                    &nbsp;&nbsp;
                    <form method="POST" action="form.php">
                        <button name="btnKeluar" class="btn btn-danger my-2 my-sm-0" type="submit" onClick="return confirm('Anda yakin untuk keluar?')">Keluar</button>
                    </form>
                </ul>
            </div>
            <br>
            <form method="POST" action="form.php" style="padding-left: 5%; padding-right: 5%;">
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Departemen</label>
                    <div class="col-sm-10">
                        <input name="inputDepartemen" type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $_SESSION['departemen'];?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input name="inputTanggal" type="text" class="form-control" id="datefield" placeholder="yyyy-mm-dd" readonly required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Waktu</label>
                    <div class="col-sm-10">
                        <select name="inputWaktu" class="form-control" id="exampleFormControlSelect1">
                            <option value="Pagi">Pagi</option>
                            <option value="Siang">Siang</option>
                            <option value="Sore">Sore</option>
                            <option value="Malam">Malam</option>
                        </select>
                    </div>
                </div>
                <button name="btnTag" type="submit" class="btn btn-primary" style="float: right; width: 100px;" onClick="return confirm('Anda yakin untuk menambahkan data ini?')">Tag</button><br><br>
                <div class="card-subtitle mb-2 text-muted" style="float:right;"><b>*Mohon cek kembali data Tag sebelum Submit</b></div>
            </form>
            <br><br>
            <section class="content" >
                <div class="container-fluid">
                    <div class="row">
                    <div class="col-md-0">
                        <div class="sticky-top mb-0">
                        <div class="card">
                            <!-- the events -->
                            <div id="external-events">
                                
                            </div>
                        </div>
                        <!-- /.card -->
                        <div class="card">
                        </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    
                    <div class="col-md-12" style="margin:0">
                        <div class="card card-primary">
                        <div class="card-body p-0">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                        </div>
                        <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div>

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

        <?php
        try {
            $sql = "SELECT departemen, (DAY(tanggal)-DAY(CURDATE())) AS 'day', (MONTH(tanggal)-MONTH(CURDATE())) AS 'mon', 
            IF(strcmp('Pagi',waktu) = 0, '#45c8d6', IF(strcmp('Siang', waktu) = 0, '#ed3e3e', IF(strcmp('Sore', waktu) = 0, '#f0a030', '#000000'))) AS 'hex' 
            FROM tag ORDER BY tanggal, id_waktu";
            $query = $dbConn->prepare($sql);
            $query->execute();
            echo "<script>
            $(function () {

                /* initialize the external events
                -----------------------------------------------------------------*/
                function ini_events(ele) {
                ele.each(function () {

                    // create an Event Object (https://fullcalendar.io/docs/event-object)
                    // it doesn't need to have a start or end
                    var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                    }

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject)

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                    zIndex        : 1070,
                    revert        : true, // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                    })

                })
                }

                ini_events($('#external-events div.external-event'))

                /* initialize the calendar
                -----------------------------------------------------------------*/
                var date = new Date()
                var d    = date.getDate(),
                    m    = date.getMonth(),
                    y    = date.getFullYear()
                 

                var Calendar = FullCalendar.Calendar;
                var Draggable = FullCalendar.Draggable;

                var containerEl = document.getElementById('external-events');
                var checkbox = document.getElementById('drop-remove');
                var calendarEl = document.getElementById('calendar');

                // initialize the external events
                // -----------------------------------------------------------------

                new Draggable(containerEl, {
                itemSelector: '.external-event',
                eventData: function(eventEl) {
                    return {
                    title: eventEl.innerText,
                    backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                    borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                    textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
                    };
                }
                });

                var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                //Random default events
                events: [";
                while ($row = $query->fetch(PDO::FETCH_ASSOC) ) {
                    echo "
                        {
                        title          : '".$row['departemen']."',
                        start          : new Date(y, m+".$row['mon'].", d+".$row['day']."),
                        allDay         : true,
                        backgroundColor: '".$row['hex']."', 
                        borderColor    : '#ffffff' 
                        },";
                }
                echo "],";
                echo "editable  : true,
                droppable : true, // this allows things to be dropped onto the calendar !!!
                drop      : function(info) {
                    // is the \"remove after drop\" checkbox checked?
                    if (checkbox.checked) {
                    // if so, remove the element from the \"Draggable Events\" list
                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                    }
                }
                });

                calendar.render();
                // $('#calendar').fullCalendar()

                /* ADDING EVENTS */
                var currColor = '#3c8dbc' //Red by default
                // Color chooser button
                $('#color-chooser > li > a').click(function (e) {
                e.preventDefault()
                // Save color
                currColor = $(this).css('color')
                // Add color effect to button
                $('#add-new-event').css({
                    'background-color': currColor,
                    'border-color'    : currColor
                })
                })
                $('#add-new-event').click(function (e) {
                e.preventDefault()
                // Get value and make sure it is not null
                var val = $('#new-event').val()
                if (val.length == 0) {
                    return
                }

                // Create events
                var event = $('<div />')
                event.css({
                    'background-color': currColor,
                    'border-color'    : currColor,
                    'color'           : '#fff'
                }).addClass('external-event')
                event.text(val)
                $('#external-events').prepend(event)

                // Add draggable funtionality
                ini_events(event)

                // Remove event from text input
                $('#new-event').val('')
                })
            })
            </script>";
        } catch (\Throwable $th) {
            echo "<script>location.reload();</script>";
        }
            
        ?>
        <script>
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
            var yyyy = today.getFullYear();
            if(dd<10){
            dd='0'+dd
            } 
            if(mm<10){
            mm='0'+mm
            } 

            today = yyyy+'-'+mm+'-'+dd;
            document.getElementById("datefield").setAttribute("min", today);

            var today1 = new Date();
            var dd1 = today1.getDate()+7;
            var mm1 = today1.getMonth()+1; //January is 0 so need to add 1 to make it 1!
            var yyyy1 = today1.getFullYear();
            if(dd1<10){
            dd1='0'+dd1
            } 
            if(mm1<10){
            mm1='0'+mm1
            } 

            today1 = yyyy1+'-'+mm1+'-'+dd1;
            document.getElementById("datefield").setAttribute("max", today1);
        </script>
    </body>
</html>
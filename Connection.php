<?php
$dbHost = 'localhost';
$dbName = 'id17187254_medinfotag';
$dbUsername = "id17187254_medinfotag123";
$dbPassword = "Korsel123!!!";
try {
	$dbConn = new PDO( "mysql:host={$dbHost};dbname={$dbName}", $dbUsername, $dbPassword );
	$dbConn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //Setting Error Mode as Exception
} catch ( PDOException $e ) {
	echo "<script>location.reload();</script>";
}
?>
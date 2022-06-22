<?php
	/*$serverName = "46.22.129.7";
	//$serverName = "localhost";
	$myUser = "usr_squirrel_dev";  
	$myPass = "7hJiy7*3"; 
	$myDB = "db_squirrel_dev"; */

$root = $_SERVER['DOCUMENT_ROOT'];
// require_once '/config.php';
require_once("$root/apleona_sqrl/config.php");
$host = DB_HOST;
$user = DB_USER;
$pass = DB_PASS;
$dbname = DB_NAME;



try {
	//$conn = new PDO('mysql:host='.$serverName.';dbname='.$myDB, $myUser, $myPass);
	$conn = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
	//$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$conn->setAttribute(PDO::ATTR_PERSISTENT, true);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
	
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
	
}

									
?>

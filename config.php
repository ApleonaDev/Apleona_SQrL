<?php

/*$serverName = "46.22.129.7";
	//$serverName = "localhost";
	$myUser = "usr_squirrel_dev";  
	$myPass = "7hJiy7*3"; 
	$myDB = "db_squirrel_dev"; */

  // DB Params
  //define("DB_HOST", "46.22.129.7");
  //define("DB_PASS", "7hJiy7*3");

    //Updated DB Params
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'db_squirrel_dev');
  
    define('JWT_KEY', 'c7c2461148405e4659a23634f7cd1b9dd8777c4550f105611a84adb47bf01402');
    define('API_ID', 'eb0816d8-996b-4072-8e93-18f5fa5fd30c');
    define('URLLOGINROOT', 'https://optimise.apleonaserv.com/Apleona_SQrL/login-exec.php');

  // define("DB_HOST", "localhost");
  // define("DB_PASS", 'L8s"d:*=DK)J!CS^');
  
  //define("DB_USER", "usr_squirrel");
  //define("DB_NAME", "db_squirrel");  
  
  // define("DB_USER", "apleona");
  // define("DB_NAME", "db_squirrel_dev");

  //define("DB_HOST", "localhost");

  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));
  // URL Root
  //define('URLROOT', 'http://optimise.apleonaserv.com/Sqrl');
  define('URLROOT', 'http://localhost/Apleona_SQrL');
  // Site Name
  define('SITENAME', 'Sqrl');
?>
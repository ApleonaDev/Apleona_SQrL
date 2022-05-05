<?php

/*$serverName = "46.22.129.7";
	//$serverName = "localhost";
	$myUser = "usr_squirrel_dev";  
	$myPass = "7hJiy7*3"; 
	$myDB = "db_squirrel_dev"; */

  // DB Params
  define("DB_HOST", "46.22.129.7");
  define("DB_PASS", "7hJiy7*3");
  
  //define("DB_USER", "usr_squirrel");
  //define("DB_NAME", "db_squirrel");  
  
  define("DB_USER", "usr_squirrel_dev");
  define("DB_NAME", "db_squirrel_dev");

  //define("DB_HOST", "localhost");

  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));
  // URL Root
  define('URLROOT', 'http://localhost/Sqrl_V1.0');
  // Site Name
  define('SITENAME', 'Sqrl');
?>
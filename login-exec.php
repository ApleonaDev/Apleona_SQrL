<?php

	//Start session
	session_start();
	
	//Include database connection details
	//require_once('config.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	//Validation error flag
	$errflag = false;
	
	//Connect to mysql server
	require_once('getSQL.php');

	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = trim($str);							 
		return $str;
		
	}
	
	//Sanitize the POST values
	$login = clean($_POST['inputUser']);
	$password = clean($_POST['inputPassword']);

	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Login ID missing';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	
	
	

	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: sqrl_login.php");
		exit();
	}
	
	// md5 RSA Data Security
	//Create query
	//$qry="SELECT * FROM dbo.Users WHERE UserName='$login' AND PasswordHash='".SHA1($_POST['password'])."'";
	
	// HASHBYTES('SHA1', [PasswordHash])
	
	$qry="SELECT * FROM users WHERE email='$login' AND password='".SHA1($_POST['inputPassword'])."'";
	//$qry="SELECT * FROM users WHERE email='$login'";
	

	//echo $qry.'<br>';
	
		try {
		$stmt = $conn->prepare($qry);
		$stmt->execute();
		if ($stmt->rowCount()){

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			
				//Login Successful
				session_regenerate_id();
		
				$_SESSION['SESS_USER_NAME'] = $row['name'];
				$_SESSION['SESS_USER_ID'] = $row['id'];
				$_SESSION['SESS_USER_TYPE'] = $row['user_type'];
				$_SESSION['SESS_USER_EMAIL'] = $row['email'];


				session_write_close();
			
				header("location: app/index.php");
				//header("location: app/head.php");
				exit();
			
			}//end while loop
		}else {
			//Login failed
			echo "TEST ERROR";
		//	header("location: login-failed.php");
			exit();
		}
		$stmt = null;
	}	catch (PDOException $e) {print $e->getMessage();}





?>
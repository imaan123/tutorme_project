<?php
 include ( "inc/connect.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	header('location: logout.php');
}
else {
	$user = $_SESSION['userlogin'];
	$result = $con->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$utype_db = $get_user_name['type'];
}

if (isset($_REQUEST['teacher'])) {
	if($_REQUEST['teacher'] == "logastchr"){
		$error = "You Logged as Teacher. Only Student can post!";
	}else{
		header('location: logout.php');
	}
}else{
		header('location: logout.php');
	}

?>

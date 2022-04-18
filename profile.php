<?php

$conn = new mysqli('localhost', 'root', '', 'main_db');

if($conn->connect_errno > 0){
    die('Unable to connect to database [' . $conn->connect_error . ']');
}

?>
<?php 

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("location: index.php");
}
else {
	$user = $_SESSION['user_login'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);

			$uname_db = $get_user_email['fullname'];
			$uemail_db = $get_user_email['email'];
			$utype_db = $get_user_email['type'];
}

if (isset($_REQUEST['uid'])) {
	$user2 = mysqli_real_escape_string($conn, $_REQUEST['uid']);
	if($user != $user2){
		header('location: index.php');
	}
}else {
	header('location: index.php');
}

//time ago convert
include_once("inc/timeago.php");
$time = new timeago();

?>
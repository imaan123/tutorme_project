<?php
 include ( "inc/connection.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	$user = "";
	$utype_db = "";
}
else {
	$user = $_SESSION['userlogin'];
	$result = $con->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$utype_db = $get_user_name['type'];
}

if($utype_db == "student"){
	$up = $con->query("UPDATE applied_post SET student_ck='yes'");
}
if($utype_db == "teacher"){
	$up = $con->query("UPDATE applied_post SET tutor_ck='yes'");
}

//time ago convert
include_once("inc/timeago.php");
$time = new timeago();

?>

<?php
 include ( "inc/connect.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header('location: login.php');
}
else {
	$user = $_SESSION['user_login'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$utype_db = $get_user_name['type'];
}

if (isset($_REQUEST['confirm'])) {
		$tid = mysqli_real_escape_string($conn, $_REQUEST['confirm']);
		$result = mysqli_query($conn, "INSERT INTO applied_post (applied_by,applied_to) VALUES ('$user','$tid')");

		$result = $conn->query("SELECT * FROM user WHERE id='$tid'");
		$get_user_name = $result->fetch_assoc();
			$uname = $get_user_name['fullname'];
			$utype = $get_user_name['type'];
		$error = "You Successfully Selected <a href='aboutme.php?uid=".$tid."' style='color: #4CAF50;'>".$uname."</a>";
}else{
		header('location: logout.php');
	}

?>

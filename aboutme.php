<?php 

ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	header("location: index.php");
}
else {
	$user = $_SESSION['userlogin'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);

			$uname_db = $get_user_email['fullname'];
			$uemail_db = $get_user_email['email'];
			$utype_db = $get_user_email['type'];
}

if (isset($_REQUEST['uid'])) {
	$user2 = mysqli_real_escape_string($conn, $_REQUEST['uid']);

	$rslttution = $conn->query("SELECT * FROM applied_post WHERE (post_by='$user2' AND applied_by='$user' AND tution_cf='1') OR applied_by='$user2' AND applied_to='$user'");

	$cnt_rslttution = $rslttution->num_rows;

	
}else {
	header('location: index.php');
}

//time ago convert
include_once("inc/timeago.php");
$time = new timeago();

?>


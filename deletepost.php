<?php

$conn = new mysqli("localhost", "root", "", "tutorme");

if($conn->connect_error)
{
    die ("connetion failed",$conn->connect_error);
}

?>
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
}

if (isset($_REQUEST['pid'])) {
	$pstid = mysqli_real_escape_string($con, $_REQUEST['pid']);
	$result3 = $conn->query("SELECT * FROM post WHERE id='$pstid'");
		$get_user_pid = mysqli_fetch_assoc($result3);
		$uid_db = $get_user_pid['postby_id'];
	if($user != $uid_db){
		header('location: post.php');
	}else{
		$result = $conn->query("DELETE FROM post WHERE id='$pstid'");
		header('location: profile.php?uid='.$user.'');
	}
}else {
	header('location: index.php');
}



?>

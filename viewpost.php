<?php
$conn = new mysqli('localhost', 'root', '', 'tutorme');

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
	{

ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	$user = "";
	$usertype = "";
}
else {
	$user = $_SESSION['userlogin'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$usertype = $get_user_name['type'];
}

//time ago convert
include_once("inc/timeago.php");
$time = new timeago();

if (isset($_REQUEST['pid'])) {
	$pstid = mysqli_real_escape_string($con, $_REQUEST['pid']);
}else {
	header('location: index.php');
}

//apply post
if (isset($_POST['post_apply'])) {
	if($user == ''){
		$_SESSION['apply_post'] = "".$pstid."";
		header("Location: login.php?pid=".$pstid."");
	}else{
		$resultpost = $conn->query("SELECT * FROM post WHERE id='$pstid'");
		$get_user_name = $resultpost->fetch_assoc();
			$postby_id = $get_user_name['postby_id'];

		$result = mysqli_query($conn, "INSERT INTO applied_post (`post_id`,`post_by`,`applied_by`,`applied_to`) VALUES ('".$pstid."','".$postby_id."','".$user."','".$postby_id."')");

		if($result){
			header("Location: viewpost.php?pid=".$pstid."");
		}else{
			echo "Could not apply!";
		}
	}
}

?>

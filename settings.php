<?php

 $con = new mysqli("localhost", "root", "", "tutorme");

if($con->connect_error)
{
    die("connection failed ", $conn->connect_error);
}

ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	$user = "";
}
else {
	$user = $_SESSION['userlogin'];
	$result = $con->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$email_db = $get_user_name['email'];
			$pro_pic_db = $get_user_name['user_pic'];
			$ugender_db = $get_user_name['gender'];
			$utype_db = $get_user_name['type'];

			if($pro_pic_db == ""){
				if($ugender_db == "male"){
					$pro_pic_db = "malepic.png";
				}else if($ugender_db == "female"){
					$pro_pic_db = "femalepic.png";

				}
			}
}

$error = "";

$senddata = @$_POST['changesettings'];
//password variable
$oldpassword = strip_tags(@$_POST['opass']);
$newpassword = strip_tags(@$_POST['npass']);
$repear_password = strip_tags(@$_POST['npass1']);
$email = strip_tags(@$_POST['email']);
$oldpassword = trim($oldpassword);
$newpassword = trim($newpassword);
$repear_password = trim($repear_password);
//update pass
if ($senddata) {
	//if the information submited
	$password_query = $con->query("SELECT * FROM user WHERE id='$user'");
	while ($row = mysqli_fetch_assoc($password_query)) {
		$db_password = $row['pass'];
		$db_email = $row['email'];
		//try to change MD5 pass
		$oldpassword_md5 = md5($oldpassword);
		if ($oldpassword_md5 == $db_password) {
			if ($newpassword == $repear_password) {
				//Awesome.. Password match.
				$newpassword_md5 = md5($newpassword);
				if (strlen($newpassword) <= 3) {
					$error = "<p class='error_echo'>Sorry! But your new password must be 3 or more then 5 character!</p>";
				}else {
				$confirmCode   = substr( rand() * 900000 + 100000, 0, 6 );
				$password_update_query = $con->query("UPDATE user SET pass='$newpassword_md5', confirmcode='$confirmCode', email='$email' WHERE id='$user'");
				$error = "<p class='succes_echo'>Success! Your settings updated.</p>";
			}
		}else {
				$error = "<p class='error_echo'>Two new password don't match!</p>";
			}
	}else {
			$error = "<p class='error_echo'>The old password is incorrect!</p>";
		}
}
}else {
	$error = "";
}

?>

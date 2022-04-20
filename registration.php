<?php

$conn = new mysqli("localhost","root","","tutorme");

if($conn->connect_error)
{
    die("Connection failed",$conn->connect_error);
}
ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	$user = "";
}
else {
	header("location: index.php");
}

$u_fname = "";
$u_email = "";
$u_mobile = "";
$u_pass = "";
if (isset($_POST['signup'])) {
//declere veriable
$u_fname = $_POST['first_name'];
$u_email = $_POST['email'];
$u_mobile = $_POST['mobile'];
$u_pass = $_POST['password'];
$u_ac = $_POST['account'];
$u_gender = $_POST['gender'];
//triming name
$_POST['first_name'] = trim($_POST['first_name']);
	try {
		if(empty($_POST['first_name'])) {
			throw new Exception('Fullname can not be empty');
			
		}
		if (is_numeric($_POST['first_name'][0])) {
			throw new Exception('Please write your correct name!');
		}
		if(empty($_POST['email'])) {
			throw new Exception('Email can not be empty');
			
		}
		if(empty($_POST['mobile'])) {
			throw new Exception('Mobile can not be empty');
			
		}
		if(empty($_POST['password'])) {
			throw new Exception('Password can not be empty');
			
		}
		
		// Check if email already exists
		
		$check = 0;
		$e_check = $conn->query("SELECT email FROM `user` WHERE email='$u_email'");
		$email_check = mysqli_num_rows($e_check);
		if (strlen($_POST['first_name']) >2 && strlen($_POST['first_name']) <16 ) {
			if ($check == 0 ) {
				if ($email_check == 0) {
					if (strlen($_POST['password']) >1 ) {
						$d = date("Y-m-d"); //Year - Month - Day
						$u_fname = ucwords($_POST['first_name']);
						$u_email = mb_convert_case($u_email, MB_CASE_LOWER, "UTF-8");
						$u_pass = md5($_POST['password']);
						$confirmCode   = mt_rand(100000, 999999);
						// send email
						$msg = "
						Assalamu Alaikum...
						
						Your activation code: ".$confirmCode."
						Signup email: ".$_POST['email']."
						
						";
						//if (@mail($_POST['email'],"eBuyBD Activation Code",$msg, "From:eBuyBD <no-reply@tutorbd.xyz>")) {
								
						//}else {

						//throw new Exception('Email is not valid!');
						//success message

						$sql = "INSERT INTO `user` (`fullname`,`gender`,`email`,`phone`,`pass`,`type`,`confirmcode`) VALUES ('".$u_fname."','".$u_gender."','".$u_email."','".$u_mobile."','".$u_pass."','".$u_ac."','".$confirmCode."')";

						if($conn->query($sql)){
							//success message
						$success_message = '
						<div class="signupform_content"><h2><font face="bookman">Registration successfull!</font></h2>
						<div class="signupform_text" style="font-size: 18px; text-align: center;">
						<font face="bookman">
							Email: '.$u_email.'<br>
							Activation code sent to your email. <br>
							Your activation code: '.$confirmCode.'
						</font></div></div>';
						}else{
							echo "Error: " . $sql . "<br>" . $con->error;
						}

						//}
						
						
					}else {
						throw new Exception('Make strong password!');
					}
				}else {
					throw new Exception('Email already taken!');
				}
			}else {
				throw new Exception('Username already taken!');
			}
		}else {
			throw new Exception('Firstname must be 2-15 characters!');
		}
	}
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
}

?>

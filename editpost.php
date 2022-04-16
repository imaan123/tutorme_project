<?php
 include ( "inc/connect.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	$user = "";
	$utype_db = "";
	header("Location: login.php");
}
else {
	$user = $_SESSION['userlogin'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$utype_db = $get_user_name['type'];
}

if (isset($_REQUEST['pid'])) {
	$pstid = mysqli_real_escape_string($con, $_REQUEST['pid']);
	$result3 = $conn->query("SELECT * FROM post WHERE id='$pstid'");
		$get_user_pid = mysqli_fetch_assoc($result3);
		$uid_db = $get_user_pid['postby_id'];
		$sub = $get_user_pid['subject'];
		$cls = $get_user_pid['class'];
		$salary = $get_user_pid['salary'];
		$location = $get_user_pid['location'];
		$p_uni = $get_user_pid['p_university'];
		$deadline = $get_user_pid['deadline'];
		$posttime = $get_user_pid['post_time'];
	if($user != $uid_db){
		header('location: index.php');
	}else{

	}
}else {
	header('location: index.php');
}

if (isset($_POST['deletepost'])) {
		$pstid = mysqli_real_escape_string($con, $_REQUEST['pid']);
		$result3 = $conn->query("SELECT * FROM post WHERE id='$pstid'");
			$get_user_pid = mysqli_fetch_assoc($result3);
			$uid_db = $get_user_pid['postby_id'];
		if($user != $uid_db){
			header('location: index.php');
		}else{
			$result = $conn->query("DELETE FROM post WHERE id='$pstid'");
			header('location: profile.php?uid='.$user.'');
		}
	}


//posting
if (isset($_POST['submit'])) {
	try {
		if(empty($_POST['location'])) {
			throw new Exception('Location can not be empty');
			
		}
		if(empty($_POST['class_list'])) {
			throw new Exception('Class can not be empty');
			
		}
		if(empty($_POST['deadline'])) {
			throw new Exception('Deadline can not be empty');
			
		}
		if(empty($_POST['sal_range'])) {
			throw new Exception('Salary range can not be empty');
			
		}
		if(empty($_POST['sub_list'])) {
			throw new Exception('Subject can not be empty');
			
		}
		if(empty($_POST['p_university'])) {
			throw new Exception('Preferred University can not be empty');
			
		}
		if(empty($_POST['medium_list'])) {
			throw new Exception('Medium can not be empty');
			
		}
		
		// Check if email already exists
						$d = date("Y-m-d"); //Year - Month - Day
							//throw new Exception('Email is not valid!');
							$sublist = implode(',', $_POST['sub_list']);
							$classlist = implode(',', $_POST['class_list']);
							$mediumlist = implode(',', $_POST['medium_list']);
							$result = mysqli_query($con, "UPDATE post SET subject='$sublist',class='$classlist',medium='$mediumlist',salary='$_POST[sal_range]',location='$_POST[location]',p_university='$_POST[p_university]',deadline='$_POST[deadline]', post_time='$posttime' WHERE id='$pstid'");
						
						//success message
						$success_message = '
						<div class="signupform_content"><h2><font face="bookman">Edit successfull!</font></h2>
						<div class="signupform_text" style="font-size: 18px; text-align: center;"></div></div>';
						
						header("Location: profile.php?uid=".$user."");
					}
				catch(Exception $e) {
					$error_message = $e->getMessage();
				}
}


?>

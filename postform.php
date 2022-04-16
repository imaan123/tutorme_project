<?php

include ( "inc/connection.inc.php" );

ob_start();
session_start();

if(!isset($_SESSION['userlogin']))
{
    $usertype = "";
    $user = "";
}
else {
	$user = $_SESSION['user_login'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$usertype = $get_user_name['type'];
}

//declearing variable
$f_loca = "";
$f_class = "";
$f_dead = "";
$f_sal = "";
$f_sub = "";
$f_uni = "";
$f_medi = "";

if(isset($_SESSION['userpost']))
{
	$f_loca=$_SESSION['f_loca'];
	$f_dead=$_SESSION['f_dead'];
	$f_sal=$_SESSION['f_sal'];
	$f_uni=$_SESSION['f_uni'];
}


//posting
if (isset($_POST['submit'])) {

	$f_loca = $_POST['location'];
	$f_dead = $_POST['deadline'];
	$f_sal = $_POST['salary'];
	//$f_sub = $_POST['sub_list'];
	$f_uni = $_POST['p_university'];
	//create session for all field
	$_SESSION['f_loca'] = $f_loca;
	$_SESSION['f_class'] = $f_class;
	$_SESSION['f_dead'] = $f_dead;
	$_SESSION['f_sal'] = $f_sal;
	$_SESSION['f_uni'] = $f_uni;


	try {
		if(empty($_POST['sub_list'])) {
			throw new Exception('Subject can not be empty');
			
		}
		if(empty($_POST['class_list'])) {
			throw new Exception('Class can not be empty');
			
		}
		if(empty($_POST['medium_list'])) {
			throw new Exception('Medium can not be empty');
			
		}
		if(empty($_POST['salary'])) {
			throw new Exception('Salary range can not be empty');
			
		}
		if(empty($_POST['location'])) {
			throw new Exception('Location can not be empty');
			
		}
		if(empty($_POST['p_university'])) {
			throw new Exception('Preferred University can not be empty');
			
		}
		if(empty($_POST['deadline'])) {
			throw new Exception('Deadline can not be empty');
			
		}
		
		
				if(($user != "") && ($usertype!="teacher"))
				{
					$d = date("Y-m-d"); //Year - Month - Day
					//throw new Exception('Email is not valid!');
					$sublist = implode(',', $_POST['sub_list']);
					$classlist = implode(',', $_POST['class_list']);
					$mediumlist = implode(',', $_POST['medium_list']);
					$result = mysqli_query($conn, "INSERT INTO post (postby_id,subject,class,medium,salary,location,p_university,deadline) VALUES ('$user','$sublist','$classlist','$mediumlist','$_POST[sal_range]','$_POST[location]','$_POST[p_university]','$_POST[deadline]')");
				
				//success message
				$success_message = '
				<div class="signupform_content"><h2><font face="bookman">Post successfull!</font></h2>
				<div class="signupform_text" style="font-size: 18px; text-align: center;"></div></div>';

				//destroy all session
				session_destroy();
				//again start user login session
				session_start();
				$_SESSION['userlogin'] = $user;
				header("Location: index.php");
				}else{
					$_SESSION['userpost'] = "post";
					header("Location: login.php");
				}
			}
			catch(Exception $e) {
				$error_message = $e->getMessage();
		}
}

//get sub list
include_once("inc/listclass.php");
$list_check = new checkboxlist();
?>

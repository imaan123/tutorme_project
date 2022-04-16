<?php

$conn = new mysqli("localhost","root","","tutorme");

if($conn->connect_error)
{
    die("Connection failed",$conn->connect_error);
}
?>

<?php
ob_start();//starting a session and output buffer
session_start();

//if the session variable is not set
if(!isset($_SESSION['userlogin'])
{
    $usertype = "";
    $user = "";
}
else
{
    header = ("locaton: index.php");
}

$emails = "";
$pass = "";

if(isset($_POST['login']))//if the user presses login
{
    //if user presses login and has input email and password
    if(isset($_POST['email']) && isset($_POST['password']))
    {
        $userlogin = $_POST['email'];
        $userlogin = mb_convert_case($userlogin,MB_CASE_LOWER,"UTF-8");
        $user_pass = $_POST['password'];
        $user_pass_md5 = md5($user_pass);//md5 hash on password.
        //find the database with the password.
        $result = $conn->query("SELECT * FROM user WHERE email='$userlogin' AND pass='$user_pass_md5');

        $welcome_user = $result-> fetch_assoc();
            $welcome_user_id = $welcome_user['id'];
            $welcome_user_type = $welcome_user['type'];

        $num = msqli_num_rows($result);
        if($num>0)
        {
            $_SESSION['userlogin']= $welcome_user_id;
            setcookie('userlogin',$userlogin,time() + (365 * 24 * 60 * 60),"/");
            $online = 'yes';
            $result = $conn->query("UPDATE user SET online= '$online' WHERE id = '$welcom_user_id'");

            if($_SESSION['u_post'] == "post")
			{
				if($get_user_type_db == "teacher"){
					$_REQUEST['teacher'] = "logastchr";
					header('location: checking.php?teacher=logastchr');
				}else{
					header('location: postform.php');
				}
			}elseif($_REQUEST['pid'] != ""){
				header('location: viewpost.php?pid='.$_REQUEST['pid'].'');
			}else{
				header('location: index.php');
			}
			exit();
		}
		else {
			header('Location: login.php');
		}
    }    
}

$acemails = "";
$acccode = "";
if(isset($_POST['activate'])){
	if(isset($_POST['actcode'])){
		$userlogin = mysql_real_escape_string($_POST['acemail']);
		$userlogin = mb_convert_case($userlogin, MB_CASE_LOWER, "UTF-8");	
		$user_acccode = mysql_real_escape_string($_POST['actcode']);
		$result2 = mysql_query("SELECT * FROM user WHERE (email='$userlogin') AND confirmCode='$user_acccode'");
		$num3 = mysql_num_rows($result2);
		echo $userlogin;
		if ($num3>0) {
			$welcome_user = mysql_fetch_assoc($result2);
			$welcome_user_id = $welcome_user['id'];
			$_SESSION['userlogin'] = $welcome_user_id;
			setcookie('userlogin', $userlogin, time() + (365 * 24 * 60 * 60), "/");
			mysql_query("UPDATE user SET confirmCode='0', activation='yes' WHERE email='$userlogin'");
			if (isset($_REQUEST['ono'])) {
				$ono = mysql_real_escape_string($_REQUEST['ono']);
				header("location: orderform.php?poid=".$ono."");
			}else {
				header('location: index.php');
			}
			exit();
		}else {
			$emails = $userlogin;
			$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Code not matched!<br>
				</font></div>';
		}
	}else {
		$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Activation code not matched!<br>
				</font></div>';
	}

}
?>
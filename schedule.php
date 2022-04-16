<?php

include("inc/connect.inc.php");

ob_start();
session_start();


if(!isset($_SESSION['userlogin']))
{    
    $user = "";
    $usertype = "";
}
$attendedby ="";
$class="";
$date="";

if(isset($_SESSION['schedule']))
{
    $attenddby = $_SESSION['attend'];
    $class = $_SESSION['class'];
    $date = $_SESSION['date'];
}

if(isset($_SESSION['submit']))
{
    $user = $_SESSION['userlogin'];
    $attendedby = $_POST['attend'];
    $class = $_POST['class'];
    $date = $_POST['date'];
    $result = $conn->query("SELECT * FROM tutor WHERE id='$user'");
    $welcome_user= $result->fetch_assoc();
        $welcome_user_id = $welcome_user['id'];
    
    $_SESSION['attend'] = $attendedby;
    $_SESSION['class']= $class;
    $_SESSION['date']=$date;

    $result2 = $conn->query("SELECT * FROM user WHERE id='$attendedby'");
    $num = mysqli_num_rows($result2);

    try
    { 
        if($numm == 0)
            throw new Exception("Attended by user not found!");
        if(empty($_POST['date']))
            throw new Exception("Date must be specified.");
    }

    $conn->query("INSERT INTO schedule VALUE($user,$attendedby,$class,$date)");

    $success_message = '
	    <div class="signupform_content"><h2><font face="bookman">Class scheduled successfully.</font></h2>
		<div class="signupform_text" style="font-size: 18px; text-align: center;"></div></div>';

	//destroy all session
	    session_destroy();
	//again start user login session
		session_start();
	$_SESSION['userlogin'] = $user;

	header("Location: index.php");
}
?>
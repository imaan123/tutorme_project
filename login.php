<?php

$conn = new mysqli('localhost', 'root', '', 'main_db');

if($conn->connect_errno > 0){
    die('Unable to connect to database [' . $conn->connect_error . ']');
}

?>

<?php
ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	$utype_db = "";
	$user = "";
}
else {
	header("location: index.php");
}
$emails = "";
$passs = "";
if (!empty($_POST['login'])) {
	if (!empty($_POST['email']) && isset($_POST['password'])) {
		//$user_login = mysql_real_escape_string($_POST['email']);
		$user_login = $_POST['email'];
		$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");
		//$password_login = mysql_real_escape_string($_POST['password']);
		$password_login = $_POST['password'];
		$password_login_md5 = md5($password_login);
		$result = $conn->query("SELECT * FROM user WHERE (email='$user_login') AND pass='$password_login_md5'");
		$num = mysqli_num_rows($result);
		$get_user_email = $result->fetch_assoc();
			$get_user_uname_db = $get_user_email['id'];
			$get_user_type_db = $get_user_email['type'];
		if ($num>0) {
			$_SESSION['userlogin'] = $get_user_uname_db;
			setcookie('userlogin', $user_login, time() + (365 * 24 * 60 * 60), "/");
			$online = 'yes';
			$result = $conn->query("UPDATE user SET online='$online' WHERE id='$get_user_uname_db'");
			if($_SESSION['u_post'] == "post")
			{
				//if (isset($_REQUEST['ono'])) {
			//	$ono = mysql_real_escape_string($_REQUEST['ono']);
			//	header("location: orderform.php?poid=".$ono."");
			//}else {
				if($get_user_type_db == "teacher"){
					$_REQUEST['teacher'] = "logastchr";
					header('location: checking.php?teacher=logastchr');
				}else{
					header('location: postform.php');
				}

			//}
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
		$user_login = mysql_real_escape_string($_POST['acemail']);
		$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");
		$user_acccode = mysql_real_escape_string($_POST['actcode']);
		$result2 = mysql_query("SELECT * FROM user WHERE (email='$user_login') AND confirmCode='$user_acccode'");
		$num3 = mysql_num_rows($result2);
		echo $user_login;
		if ($num3>0) {
			$get_user_email = mysql_fetch_assoc($result2);
			$get_user_uname_db = $get_user_email['id'];
			$_SESSION['user_login'] = $get_user_uname_db;
			setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");
			mysql_query("UPDATE user SET confirmCode='0', activation='yes' WHERE email='$user_login'");
			if (isset($_REQUEST['ono'])) {
				$ono = mysql_real_escape_string($_REQUEST['ono']);
				header("location: orderform.php?poid=".$ono."");
			}else {
				header('location: index.php');
			}
			exit();
		}else {
			$emails = $user_login;
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
<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Tutorme</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
	  <!-- Vendor CSS-->
	  <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
     <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div style="padding-top:2px">
                              <a href="index.html"><img src="images/logo1.png" alt="#" style="height:50px;width:150px"/></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item active">
                                 <a class="nav-link" href="schedule.php"> Home </a>
                              </li>
                              <li class="nav-item">
                              <?php
                              if($usertype = "publicuser")
                                 echo'<a class="nav-link" href="login.php">Posts</a>';
                              else
                                 echo'<a class="nav-link" href="viewpost.php">Posts</a>';
                              ?>
                              </li>
                              <li class="nav-item">
                              <?php
                              if($usertype = "publicuser")
                                 echo'<a class="nav-link" href="login.php">Search Tutor</a>';
                              else
                                 echo'<a class="nav-link" href="search.php">Search Tutor</a>';
                              ?>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#contact">Contact</a>
                              </li>
                              <li class="nav-item d_none">
                                 <a class="nav-link" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
                              </li>
                              <li class=" d_none get_btn">
                                 <a  href="login.php">Login</a>
                              </li>
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>


	<div  class="page-wrapper p-t-130 p-b-100 font-poppins" style="background:url('images/back1.jpg');">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
				<?php
				echo '<div class="signup_error_msg">';

						if (isset($error_message)) {echo $error_message;}


				echo'</div>';
				if(isset($success_message)) {echo $success_message;}
				else echo'
                    <h2 class="title" style="text-align:center;"><b>LOGIN</b></h2>
                    <form method="POST">
                        <hr>
                        <br>


                        <div class="row row-space">
                            <div >
                                <div class="input-gold">
                                    <label class="labelx">Email</label>
                                    <input class="input-style-gold" type="email" name="email">
                                </div>
                            </div>

                            <br>
                            <br>

                            <div >
                                <div class="input-gold">
                                    <label class="labelx">Password</label>
                                    <input class="input-style-gold" type="password" name="password">
                                </div>
                            </div>

                        </div>



                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit" name="login" value="login" style="font-weight: bold;">LOGIN</button>
                        </div>

                        <br>

                    </form>';
                    echo'<div style="float: left; padding: 10px 0 6px 4px">
                      
                    <p>Not registered yet?<a href="registration.php" style="font-weight: bold;">Register here.</a></p>
                    </div>';
					?>
                </div>
            </div>
        </div>
    </div>



</body>
</html>

<?php

$conn = new mysqli('localhost', 'root', '', 'main_db');

if($conn->connect_errno > 0){
    die('Unable to connect to database [' . $conn->connect_error . ']');
}

?>

<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$utype_db = "";
	$user = "";
}
else {
	header("location: index.php");
}
$emails = "";
$passs = "";
if (isset($_POST['login'])) {
	if (isset($_POST['email']) && isset($_POST['password'])) {
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
		if (mysqli_num_rows($result)>0) {
			$_SESSION['user_login'] = $get_user_uname_db;
			setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");
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
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#" /></div>
      </div>
      <!-- end loader -->
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



			<div style="float: right;" >
				<table>
					<tr>
						<?php
							if($user != ""){
								echo '<td>
							<a class="active navlink" href="profile.php?uid='.$user.'">'.$uname_db.'</a>
						</td>
						<td>
							<a class="navlink" href="logout.php">Logout</a>
						</td>';
							}
						?>

					</tr>
				</table>
			</div>

	<div class="nbody" style="margin: 30px 430px; overflow: hidden; ">
		<div class="nfeedleft" style="background-color: unset;">
			<div>
		<div class="testbox" style="height: 410px;">
      <br>
  <h1>LOGIN</h1>

  <form action="" method="post">
      <hr>
  <input type="text" name="email" id="name" placeholder="Email" required/><br>
  <input type="password" name="password" id="name" placeholder="Password" required/>
  <div>
  <div style="float: right; width: 35%; margin-top: 20px; padding-right: 80px;">
  	<input type="submit" class="sub_button" name="login" id="name" value="LOGIN"/><br><br>
  </div>
  <div style="width: 50%; float: left; padding: 25px 0 6px 65px">
  	<p>Forgot your password?<a href="#" style="font-weight: bold;"> Click here</a>.</p>
  <p>Not registered yet?<a href="registration.php" style="font-weight: bold;"> Register here</a>.</p>
  </div>
  </div>
  </form>
</div>
	</div>
		</div>
		<div class="nfeedright">

		</div>
	</div>
  	</div>



 <!-- homemenu tab script -->
 <script src="js/jquery.min.js"></script>
 <script src="js/popper.min.js"></script>
 <script src="js/bootstrap.bundle.min.js"></script>
 <script src="js/jquery-3.0.0.min.js"></script>
 <!-- sidebar -->
 <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
 <script src="js/custom.js"></script>
</body>
</html>

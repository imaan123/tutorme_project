<?php

include ( "inc/connect.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	$user = "";
}
else {
	$user = $_SESSION['userlogin'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
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
	$password_query = $conn->query("SELECT * FROM user WHERE id='$user'");
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
				$password_update_query = $conn->query("UPDATE user SET pass='$newpassword_md5', confirmcode='$confirmCode', email='$email' WHERE id='$user'");
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Level HTML Template</title>
<!--

Template 2095 Level

http://www.tooplate.com/view/2095-level

-->
    <!-- load stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
	  <link rel="stylesheet" href="css/main.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link rel="stylesheet" href="css/bootstrap.min.css">                                      <!-- Bootstrap style -->
    <link rel="stylesheet" type="text/css" href="css/datepicker.css"/>
    <link rel="stylesheet" href="css/style.css">                                   <!-- Templatemo style -->
	<link rel="stylesheet" href="css/tooplate-style.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
</head>

    <body>
        <header>
         <!-- header inner -->
         <div class="header">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div >
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
                                 <a class="nav-link" href="index.html"> Home </a>
                              </li>
                              <li class="nav-item d_none">
                                 <a class="nav-link" href="index.php"><i class="fa fa-search" aria-hidden="true"></i></a>
                              </li>
                              <li class=" d_none get_btn">
                                 <a href="aboutme.php?uid='.$user'">Go back to profile</a>
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
						<form action="" method="POST" class="registration">
								<div class="signup_error_msg">
									<?php echo $error; ?>
								</div>
								<div style="text-align: center;font-size: 20px;color: #aaa;margin: 0 0 5px 0;">
									<td >Change Password:</td>
								</div>
								<div>
									<td><input class="input-style-gold" type="password" name="opass" placeholder="Old Password"></td>
								</div>
								<br>
								<div>
									<td><input class="input-style-gold" type="password" name="npass" placeholder="New Password"></td>
								</div>
								<br>
								<div>
									<td><input class="input-style-gold" type="password" name="npass1" placeholder="Repeat Password"></td>
								</div>
								<div style="text-align: center;font-size: 20px;color: #aaa;margin: 0 0 5px 0;">
									<td >Change Email:</td>
								</div>
								<div>
									<td><?php echo '<input class="" required type="email" name="email" placeholder="New Email" value="'.$email_db.'">'; ?></td>
								</div>
								<div>
									<td><input class="btn btn--radius-2 btn--blue" type="submit" name="changesettings" value="Update Settings"></td>
								</div>
						</form>
					</div>
	</div>
	</div>
	</div>
	</li>

	</body>
	</html>

<?php
include("inc/connect.inc.php");

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

if(!empty($_POST['account'])) 
    $u_ac = $_POST['account'];

if(!empty($_POST['gender']))
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

						$sql = "INSERT INTO `user` (fullname,gender,email,phone,pass,type,confirmcode) VALUES ('".$u_fname."','".$u_gender."','".$u_email."','".$u_mobile."','".$u_pass."','".$u_ac."','".$confirmCode."')";
						if($conn->query($sql)){
							//success message
						$success_message = '
						<div class="signupform_content"><h2><font face="bookman">Registration successfull!</font></h2>
						<div class="signupform_content" style="font-size: 18px; text-align: center;">
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
                    <h2 class="title" style="text-align:center;"><b>Registration Form</b></h2>
                    <form method="POST">
                        <hr>
                        <br>
                        <div class="row row-space">
                            <div >
							<label class="label"><b>Account Type</b></label>
                                <div class="input-gold">
                                    
                
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-45" >teacher
                                            <input type="radio"   name="account" value="teacher">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container" >student/parent
                                            <input type="radio" name="account" value="student">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="row row-space">
                            <div >
                                <div class="input-gold">
                                    <label class="labelx">full name</label>
                                    <input class="input-style-gold" type="text" name="first_name">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div >
							<label class="labelx"><b>Gender</b></label>
                                <div class="input-gold">
                                    
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-45">Male
                                            <input type="radio"  name="gender" value="male">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Female
                                            <input type="radio" name="gender" value="female">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div >
                                <div class="input-gold">
                                    <label class="labelx">Email</label>
                                    <input class="input-style-gold" type="email" name="email">
                                </div>
                            </div>
                            <div >
                                <div class="input-gold">
                                    <label class="labelx">Phone Number</label>
                                    <input class="input-style-gold" type="text" name="mobile">
                                </div>
                            </div>
                            <div >
                                <div class="input-gold">
                                    <label class="labelx">Password</label>
                                    <input class="input-style-gold" type="password" name="password">
                                </div>
                            </div>
                            <div >
                                <div class="input-gold">
                                    <label class="labelx">Confirm Password</label>
                                    <input class="input-style-gold" type="password" name="cpassword">
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit" name="signup">Submit</button>
                        </div>
                    </form>';
					?>
                </div>
            </div>
        </div>
    </div>



</body>
</html>

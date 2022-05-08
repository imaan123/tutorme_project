<?php

include ( "inc/connect.inc.php" );

ob_start();
session_start();

if(!isset($_SESSION['userlogin']))
{
    $usertype = "";
    $user = "";
}
else {
	$user = $_SESSION['userlogin'];
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

		if(empty($_POST['sal_range'])) {
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

					$result = mysqli_query($conn, "INSERT INTO post (postby_id,subject,class,salary,location,p_university,deadline) VALUES ('$user','$sublist','$classlist','$_POST[sal_range]','$_POST[location]','$_POST[p_university]','$_POST[deadline]')");

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
                              <a href="#"><img src="images/logo1.png" alt="#" style="height:50px;width:150px"/></a>
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
                                 <a class="nav-link" href="#"> Home </a>
                              </li>
                              <li class="nav-item">
                              <?php
                              if($user != "")
                              echo'<a class="nav-link" href="postform.php">post</a>';
                              else
                                 echo'<a class="nav-link" href="login.php">post</a>';
                              echo'
                              </li>
                              <li class="nav-item">';
                              if($user != "")
                              echo'<a class="nav-link" href="search.php">Search tutor</a>';
                              else
                                 echo'<a class="nav-link" href="login.php">Search tutor</a>';
                              echo'
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#contact">Contact</a>
                              </li>';
                              if($user != "")
                              echo'<a class="nav-link" href="newsfeed.php">newsfeed</a>';
                              else
                                 echo'<a class="nav-link" href="login.php">newsfeed</a>';
                              echo'
                              <li class="nav-item">';
                              if($user != "")
                                 echo'<a class="nav-link" href="Notification.php">Notfication</a>';
                              else
                                 echo'<a class="nav-link" href="login.php">Notification</a>';
                              echo'
                              </li>';
                              if($user != "")
                              {
                                 $query = $conn->query("SELECT * FROM `user` WHERE id= '.$user'");
                                 $get_user_welcome = $query->fetch_assoc();
                                 echo'
                                 <li class="nav-item">
                                    <a class="nav-link" href="aboutme.php?uid='.$user.'">Hello '.$uname_db.'!</a>
                                 </li>
                                 <li class=" d_none get_btn">
                                 <a  href="logout.php">Logout</a>
                                 </li>';}
                              else{
                                 echo'
                              <li class=" d_none get_btn">
                                 <a  href="login.php">Login</a>
                              </li>';}
                              ?>
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
								$resultnoti = $conn->query("SELECT * FROM applied_post WHERE post_by='$user' AND student_ck='no'");
								$resultnoti_cnt = $resultnoti->num_rows;
								if($resultnoti_cnt == 0){
									$resultnoti_cnt = "";
								}else{
									$resultnoti_cnt = '('.$resultnoti_cnt.')';
								}

							}
						?>

					</tr>
				</table>
			</div>
		</div>
	</div>


  <div  class="page-wrapper p-t-130 p-b-100 font-poppins" style="background:url('images/back1.jpg'); ">
<div class ="container">
	<!-- postform -->
	<div class="nbody" style="margin: 0px 50px; overflow: hidden;">
		<div class="nfeedleft">
			<div class="postbox">
			<h3>Post Form</h3>
			<?php
				echo '<div class="signup_error_msg">';
					if (isset($error_message)) {echo $error_message;}
				echo'</div>';
				?>
			  	<form action="#" method="post">
			  		<div class="itemrow">
			  			<div style="width: 100%; float: left;">
			  				<label>Subject: </label>

  							<?php $list_check->sublist(); ?>
			  			</div>
			  		</div>

            <br>
					<div class="itemrow">
						<div style="width: 100%; float: left;">
							<label>Class: </label>
							<?php $list_check->classlist(); ?>
						</div>

					</div>
          <br>

					<div class="itemrow">
				  			<div style="width: 20%; float: left;">
				  				<label>Salary Range: </label>
				  			</div>
							<div style="width: 80%; float: left;">
								<select name="sal_range">
									<?php if($f_sal!="") echo '<option value="'.$f_sal.'">'.$f_sal.'</option>';  ?>
								  <option value="None">None</option>
								  <option value="1000-2000">1000-2000</option>
								  <option value="2000-5000">2000-5000</option>
								  <option value="5000-10000">5000-10000</option>
								  <option value="10000-15000">10000-15000</option>
								  <option value="15000-25000">15000-25000</option>
								</select>
							</div>
						</div>
				  	<div class="itemrow">
				  			<div style="width: 100%; float: left;">
				  				<label>Location: </label>
				  				<?php echo '&nbsp&nbsp&nbsp&nbsp<input type="text" name="location" value="'.$f_loca.'" placeholder="e.g: Nikunja 2, Banani">'; ?>
				  			</div>
				  		</div>
					<div class="itemrow">
				  			<div style="width: 20%; float: left;">
				  				<label>University: </label>
				  			</div>
							<div style="width: 80%; float: left;">
								<select name="p_university">
								<?php if($f_uni!="") echo '<option value="'.$f_uni.'">'.$f_uni.'</option>';  ?>
							  <option value="None">None</option>
							  <option value="Southeast University">public/private</option>
							  <option value="Brac University">Distance</option>
							  <option value="Dhaka Univesity">Any</option>
							</select>
							</div>
						</div>
					<div class="itemrow">
				  			<div style="width: 100%; float: left;">
				  				<label>Deadline: </label>
				  				<?php echo '&nbsp&nbsp&nbsp&nbsp<input name="deadline" type="text" id="datepicker" placeholder="e.g: 30/10/2017" value="'.$f_dead.'">'; ?>
				  			</div>
				  		</div>
					<input type="submit" name="submit" class="sub_button" value="Post"/></br></br>
				</form>
			</div>
		</div>
		<div class="nfeedright">

		</div>
	</div>
</div>
</div>




</body>
</html>

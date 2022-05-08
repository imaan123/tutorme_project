<?php 
include ( "inc/connect.inc.php" );
ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	header("location: index.php");
}
else {
	$user = $_SESSION['userlogin'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);

			$uname_db = $get_user_email['fullname'];
			$uemail_db = $get_user_email['email'];
			$utype_db = $get_user_email['type'];
}

if (isset($_REQUEST['uid'])) {
	$user2 = mysqli_real_escape_string($conn, $_REQUEST['uid']);

	$rslttution = $conn->query("SELECT * FROM applied_post WHERE (post_by='$user2' AND applied_by='$user' AND tution_cf='1') OR applied_by='$user2' AND applied_to='$user'");

	$cnt_rslttution = $rslttution->num_rows;

	
}else {
	header('location: index.php');
}

//time ago convert
include_once("inc/timeago.php");
$time = new timeago();

if(isset($_POST['edit']))
{
  $id = $_SESSION['userlogin'];
  $phone= $_POST['phone'];
  $address= $_POST['address'];
  $gender = $_POST['gender'];
  $type = $_POST['type'];
  $institute= $_POST['institute'];
  $class = $_POST['class'];
  $salary = $_POST['salary'];
  $subject = $_POST['subject'];
  $location= $_POST['location'];
  $a= $conn->query("SELECT * from tutor where id='.$user.'");
  if(mysqli_num_rows($a)>0)
  {;}else
    $conn->query("INSERT INTO tutor(t_id,inst_name,prefer_sub,class,prefer_location,salary) values('$user','$institute','$subject','$class','$location','$salary')");
  $conn->query("UPDATE user SET `address`='.$address' where id='.$user.'");
  $conn->query("UPDATE tutor  SET inst_name='$institute', prefer_sub='$subject', class= '$class', prefer_location='$location',salary='$salary' WHERE id='.$user.'");
  $conn->query("UPDATE user SET phone='.$phone' where id='.$user.'");
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
	  <link rel="stylesheet" href="css/bread.css">
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
                                 <a class="nav-link" href="aboutme.php"> Home </a>
                              </li>
                              
                              <?php
                              if($usertype = "publicuser")
                                 echo'
								 <li class="nav-item">
								 <a class="nav-link" href="login.php">Posts</a>
								 </li>';
                              else 
                                 echo'
								 <li class="nav-item">
								 <a class="nav-link" href="viewpost.php">Posts</a></li>';
							 
                              ?>
                              <?php
                              if($usertype = "publicuser")
                                 echo'</li>
								 <li class="nav-item">
								 <a class="nav-link" href="login.php">Search Tutor</a>
								 </li>';
                              else
                                 echo'</li>
								 <li class="nav-item">
								 <a class="nav-link" href="search.php">Search Tutor</a>
								 </li>';
                              ?>
                              
                              <li class="nav-item">
                                 <a class="nav-link" href="#contact">Contact</a>
                              </li>
                              <li class="nav-item d_none">
                                 <a class="nav-link" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
                              </li>
                              <?php
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
                              </li>';}?>
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <?php

						$query1 = $conn->query("SELECT * FROM user WHERE id='$user'");
						$user_fname = $query1->fetch_assoc();
						$uname_db = $user_fname['fullname'];
						$pro_pic_db = $user_fname['user_pic'];
						$ugender_db = $user_fname['gender'];
						$uemail_db = $user_fname['email'];
						$uphone_db = $user_fname['phone'];
						$ugender_db = $user_fname['gender'];
						$uaddress_db = $user_fname['address'];
						$utype_db = $user_fname['type'];

            $query2 = $conn->query("SELECT * FROM tutor WHERE t_id='$user' ORDER BY id DESC");
						$tutor_info = $query2->fetch_assoc();

            $uinsname_db ="";
            $umedium_db = "";
						$usalrange_db = "";
						$uclass_db = "";
						$upresub_db = "";
						$upreloca_db = "";

            if(isset($tutor_info['inst_name']))
						  $uinsname_db = $tutor_info['inst_name'];

            if(isset($tutor_info['medium']))
						  $umedium_db = $tutor_info['medium'];

            if(isset($tutor_info['salary']))
						  $usalrange_db = $tutor_info['salary'];
            if(isset($tutor_info['class']))
						  $uclass_db = $tutor_info['class'];
            if(isset($tutor_info['prefer_sub']))
						  $upresub_db = $tutor_info['prefer_sub'];
            if(isset($tutor_info['prefer_location']))
						  $upreloca_db = $tutor_info['prefer_location'];

            if($pro_pic_db == ""){

              $pro_pic_db = "images/chat.png";
            }
          else {
           
                $pro_pic_db = "images/chat.png";
          }?>
<?php
echo'
<div id ="profile_container_aboutme" class="container">

    <div class="main-body">
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="images/chat.png" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4>'.$uname_db.'</h4>
                      <p class="text-secondary mb-1">'.$utype_db.'</p>
                      <p class="text-muted font-size-sm">'.$uaddress_db.'</p>
					  <hr>';
            if($utype_db != "teacher")
            {;}
            else{echo'
					  <a href="schedule.php"><button class="btn btn-primary">Schedule</button></a>';}
            echo'
                    <a href="settings.php"><button class="btn btn-outline-primary">Settings</button></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3">
                
              </div>
            </div>
            
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      '.$uname_db.'
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      '.$uemail_db.'
                    </div>
                  </div>
                  <hr>
                  <form method="post">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input type="phone" value="'.$uphone_db.'" name="phone" style= "border:0px">
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input type="text" value="'.$uaddress_db.'" name="address" style="border:0px">
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Gender</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input type="text" value="'.$ugender_db.'" name="gender" style="border:0px">
                    </div>
                  </div>
                  <hr>
				        <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Type</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <input type="text" value="'.$utype_db.'" name="type" style="border:0px">
                    </div>
                  </div>
                  <hr>';
                  if($utype_db != "teacher")
                  {;}
                  else{
                  echo'
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Institute name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <input type="text" value="'.$uinsname_db.'" name="institute" style="border:0px">
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Class</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <input type="text" value="'.$uclass_db.'" name="class" style="border:0px">
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Salary</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <input type="text" value="'.$usalrange_db.'" name="salary" style="border:0px">
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Subjects</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <input type="text" value="'.$upresub_db.'" name="subject" style="border:0px">
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Location</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <input type="text" value="'.$upreloca_db.'" name="location" style="border:0px">
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-12">
                      <button class="btn btn-info type="submit" name="edit" value="edit">Edit</button>
                    </div>
                  </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>';}?>
</body>
</html>

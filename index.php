<?php
 include ( "inc/connect.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	$user = "";
	$usertype = "";
}
else {
	$user = $_SESSION['userlogin'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
      if($get_user_name!= NULL){
			$uname_db = $get_user_name['fullname'];
			$usertype = $get_user_name['type'];}
}

//time ago convert
include_once("inc/timeago.php");
$time = new timeago();
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
                                 <a class="nav-link" href="logout.php"> Home </a>
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
                              echo'
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#contact">Contact</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="viewpost.php">viewpost</a>
                              </li>
                              <li class="nav-item d_none">
                                 <a class="nav-link" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
                              </li>';
                              if($user != "")
                              {
                                 $query = $conn->query("SELECT * FROM `user` WHERE id= '.$user'");
                                 $get_user_welcome = $query->fetch_assoc();
                                 echo'
                                 <li class="nav-item">
                                    <a class="nav-link" href="profile.php?uid='.$user.'">Hello '.$uname_db.'!</a>
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
      <!-- end header inner -->
      <!-- end header -->
      <!-- banner -->
      <section class="banner_main">
         <div class="container">
            <div class="row">
               <div class="col-md-12 ">
                  <div class="text-bg">
                     <h1 style="font-family:'Fantasy',Papyrus">Tutor Me</h1>
					 <br>
					 <br>
                     <p style="font-size:2.5rem"><i>Find your nearest tutor. Great results, completely free.</i></p>
                     <a href="registration.php"><b>Register now</b></a>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- end banner -->
      <!-- three_box -->
      <div class="three_box">
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                  <div class="box_text">
                     <figure><img src="images/image1.jpeg" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="box_text">
                     <figure><img src="images/image2.jpg" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="box_text">
                     <figure><img src="images/image3.jpg" alt="#"/></figure>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- three_box -->
      <!-- hottest -->
      <div  class="hottest">
         <div class="container">
            <div class="row d_flex">
               <div class="col-md-5">
                  <div class="titlepage">
                     <h2>The best destination for learning</h2>
                  </div>
               </div>
               <div class="col-md-7">
                  <div class="hottest_box">
                     <p>This is an online platform through which students and teachers can connect, interact and learn. We aspire to provide a flexible platform for students to search and find for tutors in their locality. An open platform for everybody.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>
      </div>
      <!-- end hottest -->
      <!-- choose  section -->
      <div class="choose ">
         <div class="container">
            <div class="row">
               <div class="col-md-8">
                  <div class="titlepage">
                     <h2>Why Choose Us? </h2>
                     <p>We provide a variety of features and additions on our website. Some of them include:</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="container-fluid">
            <div class="row d_flex">
               <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
                  <div class="padding_with">
                     <div class="row">
                        <div class="col-md-6 padding_bottom">
                           <div class="choose_box">
                              <i><img src="images/icon1.png" alt="#"/></i>
                              <div class="choose_text">
                                 <h3>Excellent Service</h3>
                                 <p>Fast,quick and reliable searches. Accurate results.</p>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 padding_bottom">
                           <div class="choose_box">
                              <i><img src="images/icon2.jpg" alt="#"/></i>
                              <div class="choose_text">
                                 <h3>Secure and reliable</h3>
                                 <p>A set of experts to evaluate every profile on the website.</p>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 padding_bottom2">
                           <div class="choose_box">
                              <i><img src="images/icon2.jpg" alt="#"/></i>
                              <div class="choose_text">
                                 <h3>Tutor friendly</h3>
                                 <p>Tutors can create profile, schedule and apply for free.</p>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="choose_box">
                              <i><img src="images/icon3.png" alt="#"/></i>
                              <div class="choose_text">
                                 <h3>Student friendly</h3>
                                 <p>Students can find tutors without any search-fee.</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                  <div class="choose_img">
                     <figure><img src="images/tutor.jpeg" alt="#"/></figure>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>
      <!-- end choose  section -->
      
      <!-- about -->
      <div class="about">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Users Say About Tutorme</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div id="myCarousel" class="carousel slide about_Carousel " data-ride="carousel">
                     <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                     </ol>
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <div class="container">
                              <div class="carousel-caption ">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="test_box">
                                          <i><img src="images/chat.png" alt="#"/></i>
                                          <h4>Student</h4>
                                          <p style="font-size:2rem">"This has become my favourite platform for tutor search."</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <div class="container">
                              <div class="carousel-caption">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="test_box">
                                          <i><img src="images/chat.png" alt="#"/></i>
                                          <h4>Tutor</h4>
                                          <p style="font-size:2rem">"It was hard finding a platform which is completely free to register. Tutorme has helped me restart my career. Thanks, Tutorme."</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <div class="container">
                              <div class="carousel-caption">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="test_box">
                                          <i><img src="images/chat.png" alt="#" style="mix-blend-mode: multiply;"/></i>
                                          <h4>Parent</h4>
                                          <p style="font-size:2rem">"I must say that this platform is very secure. My son has great remarks about all his tutors. Thank you."</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                     </a>
                     <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end about -->
      </div>
      <!--  footer -->
      <footer id="contact">
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class="col-md-4">
                     <div class="titlepage" id="contact">
                        <h2>Contact Us</h2>
						
                     </div>
					 <hr >
					 <h4 style="color:white;">Imaan Ahmad, Shifali R S, Srungarapati Beaula</h4>
					 <h4 style="color:white;">National Institute of Technology, Karnataka.</h4>
					 <br>
					 <br>
					 <br>
                  </div>
				</div>
			</div>
		</div>            
      </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>

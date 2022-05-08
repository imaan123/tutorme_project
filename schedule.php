<?php

include("inc/connect.inc.php");

ob_start();
session_start();

if(!isset($_SESSION['userlogin']))
{    
    $user = "";
    $usertype = "publicuser";
    header("Location: index.php");
}else{
 $user = $_SESSION['userlogin'];}
$attendedby ="";
$class="";
$date="";

if(isset($_SESSION['schedule']))
{
    $attenddby = $_SESSION['studid'];
    $class = $_SESSION['classname'];
    $date = $_SESSION['date'];
    $time =  $_SESSION['time'];
}

if(isset($_POST['schedule']))
{
    $user = $_SESSION['userlogin'];
    $attendedby = $_POST['studid'];
    $class = $_POST['classname'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $result = $conn->query("SELECT * FROM tutor WHERE id='$user'");
    $welcome_user= $result->fetch_assoc();
        $welcome_user_id = $welcome_user['id'];
    
       
    $result2 = $conn->query("SELECT * FROM user WHERE id='$attendedby'");
    $num = mysqli_num_rows($result2);

    $_SESSION['attend'] = $attendedby;
    $_SESSION['class']= $class;
    $_SESSION['date']=$date;
    $_SESSION['time']=$time;

    try
    { 
        if($num == 0)
            throw new Exception("Attended by user not found!");
        if(empty($_POST['date']))
            throw new Exception("Date must be specified.");
        
    }catch(Exception $e) {
        $error_message = $e->getMessage();
    }

    $sql = $conn->query("INSERT INTO schedule(scheduled_by,attended_by,class,date_time) VALUES('$user','$attendedby','$class','$date $time')");
    $success_message =
	    '<div class="signupform_content"><h2><font face="bookman">Class scheduled successfully.</h2></div>';
	//destroy all session
	    session_destroy();
	//again start user login session
		session_start();
	$_SESSION['userlogin'] = $user;
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
	  <!--HEADER END-->
      <?php if(isset($success_message)) {echo $success_message;}
      else{
      echo'
            <div class="tm-section tm-bg-img" id="tm-section-1">
                <div class="tm-bg-white ie-container-width-fix-2">
				<h1 style="color:white">Schedule class</h1>
				<hr style="background-color:white">
                    <div class="container ie-h-align-center-fix">
                        <div class="row">
                            <div class="col-xs-12 ml-auto mr-auto ie-container-width-fix">
                                <form method="POST" class="tm-search-form tm-section-pad-2">
                                    <div class="form-row tm-search-form-row">
                                        <div class="form-group tm-form-element tm-form-element-100">
                                            <i class="fa fa-map-marker fa-2x tm-form-element-icon"></i>
                                            <input name="classname" type="text" class="form-control" placeholder="Class name">
                                        </div>
                                        <div class="form-group tm-form-element tm-form-element-50">
                                            <i class="fa fa-calendar fa-2x tm-form-element-icon"></i>
                                            <input name="date" type="date" class="form-control"  placeholder="Date">
                                        </div>
                                        <div class="form-group tm-form-element tm-form-element-50">
                                            <input name="time" type="time" class="form-control" placeholder="Time">
                                        </div>
                                    </div>
                                    <div class="form-row tm-search-form-row">
										<div class="form-group tm-form-element tm-form-element-50">
                                            <input name="studid" type="text" class="form-control" placeholder="Student id">
                                        </div>
                                        <div class="form-group tm-form-element tm-form-element-2">
                                            <button type="submit" class="btn btn-primary tm-btn-search" name="schedule">Schedule</button>
                                        </div>
                                      </div>
                                      <div class="form-row clearfix pl-2 pr-2 tm-fx-col-xs">
                                          <a href="#" class="ie-10-ml-auto ml-auto mt-1 tm-font-semibold tm-color-primary">Need Help?</a>
                                      </div>
                                </form>
                            </div>                        
                        </div>      
                    </div>
                </div>                  
            </div>';}
            ?>
        
        
        <!-- load JS files -->
        <script src="js/jquery-1.11.3.min.js"></script>             <!-- jQuery (https://jquery.com/download/) -->
        <script src="js/popper.min.js"></script>                    <!-- https://popper.js.org/ -->       
        <script src="js/bootstrap.min.js"></script>                 <!-- https://getbootstrap.com/ -->
        <script src="js/datepicker.min.js"></script>                <!-- https://github.com/qodesmith/datepicker -->
        <script src="js/jquery.singlePageNav.min.js"></script>      <!-- Single Page Nav (https://github.com/ChrisWojcik/single-page-nav) -->
        <script src="slick/slick.min.js"></script>                  <!-- http://kenwheeler.github.io/slick/ -->        

</body>
</html>

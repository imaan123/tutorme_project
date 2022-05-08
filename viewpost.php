<?php

$conn = new mysqli('localhost', 'root', '', 'tutorme');

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
	$user = $_SESSION['userlogin'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$usertype = $get_user_name['type'];
}

//time ago convert
include_once("inc/timeago.php");
$time = new timeago();

if (isset($_REQUEST['pid'])) {
	$pstid = mysqli_real_escape_string($con, $_REQUEST['pid']);
}else {
	//header('location: index.php');
}

//apply post
if (isset($_POST['post_apply'])) {
	if($user == ''){
		$_SESSION['apply_post'] = "".$pstid."";
		header("Location: login.php?pid=".$pstid."");
	}else{
		$resultpost = $conn->query("SELECT * FROM post WHERE id='$pstid'");
		$get_user_name = $resultpost->fetch_assoc();
			$postby_id = $get_user_name['postby_id'];

		$result = mysqli_query($conn, "INSERT INTO applied_post (`post_id`,`post_by`,`applied_by`,`applied_to`) VALUES ('".$pstid."','".$postby_id."','".$user."','".$postby_id."')");

		if($result){
			header("Location: viewpost.php?pid=".$pstid."");
		}else{
			echo "Could not apply!";
		}
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
                                 <a class="nav-link" href="index.php"> Home </a>
                              </li>
                              <li class="nav-item">
                              <?php
                              if($usertype = "publicuser")
                                 echo'<a class="nav-link" href="login.php">Posts</a>';
                              else 
                                 echo'<a class="nav-link" href="viewpost.php">viewpost</a>';
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
	  		<?php 
			if($utype_db == "teacher")
				
			 ?>
			 			<div style="float: right;" >
				<table>
					<tr>
						
						
					</tr>
				</table>
			</div>
		</div>
	</div>
	<!-- newsfeed -->
	<div class="nbody" style="margin: 0px 100px; overflow: hidden;">
		<div class="nfeedleft">

				<?php
					$todaydate = date("m/d/Y"); //Month/Day/Year 12/20/2017

					$query = $conn->query("SELECT * FROM post WHERE id= '$pstid'");
					while ($row = $query->fetch_assoc()) {
						$postby_id = $row['postby_id'];
						$sub = $row['subject'];
						$class = $row['class'];
						$salary = $row['salary'];
						$location = $row['location'];
						$p_university = $row['p_university'];
						$post_time = $row['post_time'];
						$deadline = $row['deadline'];
					

						$query1 = $conn->query("SELECT * FROM user WHERE id='$postby_id'");
						$user_fname = $query1->fetch_assoc();
						$uname_db = $user_fname['fullname'];
						$pro_pic_db = $user_fname['user_pic'];
						$ugender_db = $user_fname['gender'];

						if($pro_pic_db == ""){
								if($ugender_db == "male"){
								$pro_pic_db = "malepic.png";
							}else if($ugender_db == "female"){
								$pro_pic_db = "femalepic.png";

							}
						}else {
							if (file_exists("image/profilepic/".$pro_pic_db)){
							//nothing
							}else{
									if($ugender_db == "male"){
									$pro_pic_db = "malepic.png";
								}else if($ugender_db == "female"){
									$pro_pic_db = "femalepic.png";

								}
							}
						}

						echo '
							<div class="nfbody">
							<div class="p_head">
							<div style="float: right;">';
								if($user!='' && $utype_db=='student'){
										echo "<span style='color: red;'>Only teacher can apply!</span>";
								}else {
									if((strtotime($deadline) - strtotime($todaydate)) < 0){
										echo '
										<input type="submit" class="sub_button" style="margin: 0px; background-color: #a76d6d; cursor: default;" name="" value="Deadline Over" />';
									}else{
										$resultpostcheck = $con->query("SELECT * FROM applied_post WHERE post_id='$pstid' AND applied_by='$user'");
											$query_apply_cnt = $resultpostcheck->num_rows;
											if($query_apply_cnt > 0){
												echo '
											<input type="button" class="sub_button" style="margin: 0px; background-color: #a76d6d; cursor: default;" name="" value="Already Applied" />';
											}else{
											echo '<form action="" method="post">
											<input type="submit" class="sub_button" style="margin: 0px;" name="post_apply" value="Confirm Apply" />
										</form>';
												}
										
									}
								}
							echo '</div>
							<div>
								<img src="image/profilepic/'.$pro_pic_db.'" width="41px" height="41px">
							</div>
							<div class="p_nmdate">
								<h4>'.$uname_db.'</h4>
								<h5 style="color: #757575;">'.$time->time_ago($post_time).' &nbsp;|&nbsp; Deadline: '.$deadline.'</h5>
							</div>
						</div>
						<div class="p_body">
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<p><label>Subject: </label></p>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$sub.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>Class: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$class.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>Medium: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$medium.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>Salary: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$salary.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>Location: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$location.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>Preferred University: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$p_university.'</span>
					  			</div>
					  		</div>
						</div>
					</div>';

					}
				?>
		</div>
		<div class="nfeedright">
			
		</div>
	</div>
				</body>
				</html>

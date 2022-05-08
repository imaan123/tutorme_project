<?php
 include ( "inc/connect.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	header('location: login.php');
}
else {
	$user = $_SESSION['userlogin'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$utype_db = $get_user_name['type'];
}

if (isset($_REQUEST['confirm'])) {
		$tid = mysqli_real_escape_string($conn, $_REQUEST['confirm']);
		$result = mysqli_query($conn, "INSERT INTO applied_post (applied_by,applied_to) VALUES ('$user','$tid')");

		$result = $conn->query("SELECT * FROM user WHERE id='$tid'");
		$get_user_name = $result->fetch_assoc();
			$uname = $get_user_name['fullname'];
			$utype = $get_user_name['type'];
		$error = "You Successfully Selected <a href='aboutme.php?uid=".$tid."' style='color: #4CAF50;'>".$uname."</a>";
}else{
		header('location: logout.php');
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
	  
						<?php
							if($user != "")
								$resultnoti = $conn->query("SELECT * FROM applied_post WHERE post_by='$user' AND student_ck='no'");
								$resultnoti_cnt = $resultnoti->num_rows;
								if($resultnoti_cnt == 0){
									$resultnoti_cnt = "";
								}else{
									$resultnoti_cnt = '('.$resultnoti_cnt.')';
								}
								
						?>
						
					</tr>
				</table>
			</div>
		</div>
	</div>

	<!-- newsfeed -->
	<div class="nbody" style="margin: 0px 100px; overflow: hidden;">
		<div class="nfeedleft">

			<?php
					echo '
						<div class="nfbody">
					<div class="p_body">
						<p>'.$error.'</p>
					</div>
				</div>';

			?>
		</div>
		<div class="nfeedright">
 </div>
</div>


	
 </div>
</div>
</body>
</html>

<?php
 include ( "inc/connect.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	$user = "";
	$utype_db = "";
}
else {
	$user = $_SESSION['userlogin'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$utype_db = $get_user_name['type'];
}

if($utype_db == "student"){
	$up = $conn->query("UPDATE applied_post SET student_ck='yes'");
}
if($utype_db == "teacher"){
	$up = $conn->query("UPDATE applied_post SET tutor_ck='yes'");
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
							if($user != "")
								if($utype_db == 'teacher'){
									$resultnoti = $conn->query("SELECT * FROM applied_post WHERE (applied_by='$user' AND tution_cf='1' AND tutor_ck='no') OR (applied_to='$user' AND tutor_ck='no')" );
								}else{
									$resultnoti = $conn->query("SELECT * FROM applied_post WHERE post_by='$user' AND student_ck='no'");
								}
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
					$todaydate = date("m/d/Y"); //Month/Day/Year 12/20/2017

					if($utype_db == 'teacher'){
						$query = $conn->query("SELECT * FROM applied_post WHERE (applied_by='$user' AND tution_cf='1') OR (applied_to='$user') ORDER BY id DESC");
						$nmrow = $query->num_rows;
						if($nmrow == 0){
							echo '
								<div class="nfbody">
								<div class="p_head">
								<div class="p_nmdate">
									<h5>No Notification Found!</h5>
								</div>
							</div>
						</div>';
						}else{
						while ($row = $query->fetch_assoc()) {
							$post_id = $row['post_id'];
							$applied_by_id = $row['applied_by'];
							$post_by_id = $row['post_by'];
							$deadline = $row['applied_time'];
							$tution_confirm = $row['tution_cf'];

							if($post_by_id == 0) $post_by_id = $applied_by_id;

							$query1 = $conn->query("SELECT * FROM user WHERE id='$post_by_id'");
							$user_fname = $query1->fetch_assoc();
							$uname_db = $user_fname['fullname'];
							$pro_pic_db = $user_fname['user_pic'];
							$ugender_db = $user_fname['gender'];

							if($post_id == ""){
								$notimsg = "applied on your tution! ";
							}else{
								$notimsg = "Choose you as tutor! ";
							}
						

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
										
												echo '<form action="aboutme.php?uid='.$post_by_id.'" method="post">
										<input type="submit" class="sub_button"  style="margin: 0px;" name="" value="View Contact" />
									</form>';
								echo '</div>
								<div>
									<img src="image/profilepic/'.$pro_pic_db.'" width="41px" height="41px">
								</div>
								<div class="p_nmdate">
									<h4><a href="aboutme.php?uid='.$post_by_id.'" style="color: #087E0D;">'.$uname_db.'</a> <span style="color: #626262; font-weight: 100;">'.$notimsg.'</span></h4>
									<h5 style="color: #757575;"><a class="c_ptime" >'.$time->time_ago($deadline).'</a></h5>
								</div>
							</div>
						</div>';



						}
						}
						
					}elseif($utype_db == 'student'){
						$query = $conn->query("SELECT * FROM applied_post WHERE post_by='$user' ORDER BY id DESC");
						while ($row = $query->fetch_assoc()) {
							$post_id = $row['post_id'];
							$applied_by_id = $row['applied_by'];
							$deadline = $row['applied_time'];
							$tution_confirm = $row['tution_cf'];

							$query1 = $conn->query("SELECT * FROM user WHERE id='$applied_by_id'");
							$user_fname = $query1->fetch_assoc();
							$uname_db = $user_fname['fullname'];
							$pro_pic_db = $user_fname['user_pic'];
							$ugender_db = $user_fname['gender'];

							if($post_id == ""){
								$notimsg = "applied on your tution ";
							}else{
								$notimsg = "want to teach you! ";
							}

							if($pro_pic_db == ""){

									$pro_pic_db = "images/chat.png";
								
							}else {
								if (file_exists("images/".$pro_pic_db)){
								//nothing
								}else{
										$pro_pic_db = "images/chat.png";

									}
								}
							}



							echo '
								<div class="nfbody">
								<div class="p_head">
								<div style="float: right;">';
										
											
												if($tution_confirm == "1"){
													echo '
												<input type="button" class="sub_button" style="margin: 0px; background-color: #a76d6d; cursor: default;" name="" value="Already Confirm" />';
												}else{
												echo '<form action="approvetutor.php?app_tut='.$post_id.'" method="post">
										<input type="submit" class="sub_button"  style="margin: 0px;" name="" value="Confirm" />
									</form>';
										}
								echo '</div>
								<div>
									<img src="'.$pro_pic_db.'" width="41px" height="41px">
								</div>
								<div class="p_nmdate">
									<h4><a href="aboutme.php?uid='.$applied_by_id.'" style="color: #087E0D;">'.$uname_db.'</a> <span style="color: #626262; font-weight: 100;">'.$notimsg.'</span></h4>
									<h5 style="color: #757575;"><a class="c_ptime" href="viewpost.php?pid='.$post_id.'">'.$time->time_ago($deadline).'</a></h5>
								</div>
							</div>
						</div>';



						}
					
				?>
		</div>
		<div class="nfeedright">
			
		</div>
	</div>


       </div>
				</div>
 </body>
</html>


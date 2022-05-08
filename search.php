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
		if($get_user_name!= NULL){
			$uname_db = $get_user_name['fullname'];
			$utype_db = $get_user_name['type'];}
}

//time ago convert
include_once("inc/timeago.php");
$time = new timeago();


//declearing variable
$f_loca = "";
$f_class = "";
$f_dead = "";
$f_sal = "";
$f_sub = "";
$f_uni = "";
$f_medi = "";


//$f_sub = $_POST['sub_list'];

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


	
	  <div style="float: right;" >
				<table>
					<tr>
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

	<!-- search -->
	<div  class="page-wrapper p-t-130 p-b-100 font-poppins" style="background:url('images/back1.jpg');">
	<div class = "container">
	<div class="nbody" style="margin: 0px 100px; overflow: hidden;">
		<div class="nfeedleftsearch">
			<div class="postbox">
			<h3>Search Tutor</h3>
			<?php
				echo '<div class="signup_error_msg">';
					
						if (isset($error_message)) {echo $error_message;}
						
					
				echo'</div>';
				?>
			  	<form method="post">
			  		<div class="itemrow">
			  			<div style="width: 10%; float: left;">
			  				<label>Subject: </label>
			  			</div>
			  			<div style="width: 75%; float: left;">
			  				<?php $list_check->sublistcombo(); ?>
			  			</div>
			  		</div>
			  	
				
					<div class="itemrow">
						<div style="width: 15%; float: left;">
							<label>Class:</label>
						</div>
						<div style="width: 75%; float: left;">
							<?php $list_check->classlistcombo(); ?>
						</div>
						
					</div>
				  	
					<div class="itemrow">
				  			<div style="width: 25%; float:center;">
							<td><label> Salary Range:</label></td>
				  			</div>
							<div style="width: 75%; float: left;">
								<select name="sal_range" style="width: 180px;">
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
				  			<div style="width: 25%; float: left;">
				  				<label>Location: </label>
				  			</div>
				  			<div style="width: 75%; float: left;" >
				  				<?php echo '<input type="text" style="width: 174px;" name="location" value="'.$f_loca.'" placeholder="e.g: mangalore, vijayawada">'; ?>
				  			</div>
				  		</div>
					<div class="itemrow">
				  			<div style="width: 25%; float: left;">
				  				<label>Type of University: </label>
				  			</div>
							<div style="width: 75%; float: left;">
								<select name="p_university" style="width: 180px;">
								<?php if($f_uni!="") echo '<option value="'.$f_uni.'">'.$f_uni.'</option>';  ?>
							  <option value="None">None</option>
							  <option value="Southeast University">public/private</option>
							  <option value="Brac University">Distance</option>
							  <option value="Dhaka Univesity">Any</option>
							</select>
							</div>
						</div>
					<input type="submit" name="submit" class="sub_button" value="Search"/></br></br>
				</form>
			</div>
		</div>
		<div class="nfeedrightsearch">
			<?php
				if (isset($_POST['submit'])){
					$f_sub = $_POST['sublistcombo'];
					$f_sub = mysqli_real_escape_string($conn, $f_sub);
					$f_class = $_POST['classlistcombo'];
					$f_class = mysqli_real_escape_string($conn, $f_class);
					
					$f_sal = $_POST['sal_range'];
					$f_sal = mysqli_real_escape_string($conn, $f_sal);
					$f_loca = $_POST['location'];
					$f_loca = mysqli_real_escape_string($conn, $f_loca);
					$f_university = $_POST['p_university'];
					$f_university = mysqli_real_escape_string($conn, $f_university);


					//if(($f_class && $f_sal && $f_loca && $f_university) == ""){
					//	$query_sub = $conn->query("SELECT * FROM tutor WHERE prefer_sub LIKE '%{$f_sub}%' ORDER BY id DESC ");
					//}

					$condition = '1=1';

					if ($f_sub != "None"){
					    $condition = $condition . " AND prefer_sub LIKE '%{$f_sub}%' ";
					} 

					if ($f_class != "None"){
					    $condition =  $condition . " AND class LIKE '%{$f_class}%' ";
					} 


					if ($f_sal != "None"){
					    $condition =  $condition . " AND salary LIKE '%{$f_sal}%' ";
					}

					if ($f_loca != ""){
					    $condition =  $condition . " AND prefer_location LIKE '%{$f_loca}%' ";
					} 

					if ($f_university != "None"){
					    $condition =  $condition . " AND inst_name LIKE '%{$f_university}%' ";
					} 

				
					if($condition == "1=1"){
						echo '
						<div class="nfbody">
						<div class="p_body">
							<div class="itemrow" style="text-align: center;">
					  				<p><label>Please Select Search Item</label></p>
					  		</div>
						</div>
					</div>

					';
					}else{
						$query_sub = $conn->query("SELECT * FROM `tutor` WHERE ".$condition);
						$query_sub_cnt = $query_sub->num_rows;
						if($query_sub_cnt == 0){
							$query_sub_cnt = "No";
						}
						echo '
						<div class="nfbody">
						<div class="p_body">
							<div class="itemrow" style="text-align: center;">
					  				<p><label>'.$query_sub_cnt.' Tutor Found </label></p>
					  		</div>
						</div>
					</div>';
					
					while($row = $query_sub->fetch_assoc()) { 
						$post_id = $row['id'];
						$tutor_id = $row['t_id'];
						$sub = $row['prefer_sub'];
						$sub = str_replace(",", ", ", $sub);
						$class = $row['class'];
						$class = str_replace(",", ", ", $class);
						$salary = $row['salary'];
						$location = $row['prefer_location'];
						$location = str_replace(",", ", ", $location);
						$p_university = $row['inst_name'];
						

						$query1 = $conn->query("SELECT * FROM user WHERE id='$tutor_id'");
						$user_fname = $query1->fetch_assoc();
						$uname_db = $user_fname['fullname'];
						$pro_pic_db = $user_fname['user_pic'];
						$ugender_db = $user_fname['gender'];
						$last_login = $user_fname['last_logout'];
						$cntnm = "";
						if($user != ""){
							$query6 = $conn->query("SELECT * FROM applied_post WHERE applied_by='$user' AND applied_to='$tutor_id'");
							$cntnm = $query6->num_rows;
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

									if($cntnm > 0){
										echo '
									<input type="button" class="sub_button" style="margin: 0px; background-color: #a76d6d;" name="" value="Selected" />
								';
									}elseif($user == $tutor_id){
										
									}else{
										echo '<form action="confirmteacher.php?confirm='.$tutor_id.'" method="post">
									<input type="submit" class="sub_button" style="margin: 0px;" name="post_apply" value="Select" />
								</form>';
									}

							echo '</div>
							<div>
								<img src="'.$pro_pic_db.'" width="41px" height="41px">
							</div>
							<div class="p_nmdate">
								<h4>'.$uname_db.'</h4>
								<h5 style="color: #757575;"><a class="c_ptime" href="viewpost.php?pid='.$post_id.'">Active '.$time->time_ago($last_login).'</a></h5>
							</div>
						</div>
						<div class="p_body">
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<p><label>Teaches: </label></p>
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
					  				<label>Salary: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$salary.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>Area: </label>
					  				<span>'.$location.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>University: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$p_university.'</span>
					  			</div>
					  		</div>
						</div>
					</div>';

					}
				}

				
			?>
		</div>
			</div>
	</div>
	<!-- footer -->

</div>
			</div>



</body>
</html>


<?php
 include ( "inc/connect.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("Location: index.php");
	$user = "";
	$utype_db = "";
}
else {
	$user = $_SESSION['user_login'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$utype_db = $get_user_name['type'];
}

if (isset($_REQUEST['uid'])) {
	$pstid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
	$result1 = $conn->query("SELECT * FROM tutor WHERE t_id='$user' ORDER BY id DESC");
	$get_tutor_name = $result1->fetch_assoc();
	$tid_db = $get_tutor_name['t_id'];
	$id_db = $get_tutor_name['id'];
	$uinst_db = $get_tutor_name['inst_name'];
	$medium = $get_tutor_name['medium'];
	$cls = $get_tutor_name['class'];
	$sub = $get_tutor_name['prefer_sub'];
	$f_sal = $get_tutor_name['salary'];
	$plocation_db = $get_tutor_name['prefer_location'];

	if($user != $_REQUEST['uid']){
		header('location: index.php');
	}else{

	}
}else {
	header('location: index.php');
}


//posting
if (isset($_POST['updatetutioninfo'])) {

	$f_loca = $_POST['location'];
	$f_sal = $_POST['sal_range'];


	try {
				if(($user == $_REQUEST['uid']) && ($utype_db == "teacher"))
				{
					
					//throw new Exception('Email is not valid!');
					$sublist = implode(',', $_POST['sub_list']);
					$classlist = implode(',', $_POST['class_list']);
					$mediumlist = implode(',', $_POST['medium_list']);

					//not working!!!!!!!!!!!!
					//$result3 = mysqli_query($conn, "UPDATE tutor SET prefer_sub='$sublist',class='$classlist',medium='$mediumlist',salary='$f_sal',prefer_location='$f_loca', WHERE t_id='$user'");

					if($result4 = $conn->query("INSERT INTO tutor (t_id,prefer_sub,class,medium,inst_name,salary,prefer_location) VALUES ('$user','$sublist','$classlist','$mediumlist','$uinst_db','$_POST[sal_range]','$_POST[location]')")){
						$result = $conn->query("DELETE FROM tutor WHERE id='$id_db'");
						
					}
				
				//success message
				$success_message = '
				<div class="signupform_content"><h2><font face="bookman">Post successfull!</font></h2>
				<div class="signupform_text" style="font-size: 18px; text-align: center;"></div></div>';

				header("Location: aboutme.php?uid=".$user."");
				}
			}
			catch(Exception $e) {
				$error_message = $e->getMessage();
		}
}


?>

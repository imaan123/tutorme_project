<?php
 include ( "inc/connect.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	$user = "";
}
else {
	$user = $_SESSION['userlogin'];
	$result = $conn->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$email_db = $get_user_name['email'];
			$uphone_db = $get_user_name['phone'];
			$pro_pic_db = $get_user_name['user_pic'];
			$uaddress_db = $get_user_name['address'];
			$ugender_db = $get_user_name['gender'];
			$utype_db = $get_user_name['type'];

			$result1 = $conn->query("SELECT * FROM tutor WHERE t_id='$user' ORDER BY id DESC");
		$get_tutor_name = $result1->fetch_assoc();
			$uinst_db = $get_tutor_name['inst_name'];
			$umedium_db = $get_tutor_name['medium'];
			$usalrange_db = $get_tutor_name['salary'];

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
}


//update pic
if (isset($_POST['updatepic'])) {
	//finding file extention
$profile_pic_name = @$_FILES['profilepic']['name'];
if($profile_pic_name == ""){
	if($result = $conn->query("UPDATE user SET phone='$_POST[phone]', address='$_POST[address]' WHERE id='$user'")){
				$succs_message = "Information Updated.";
		}
		if($utype_db == "teacher"){
				if($result = $conn->query("UPDATE tutor SET inst_name='$_POST[inst_nm]' WHERE t_id='$user'")){
					$succs_message = "Informaion Updated!";
				}
			}
		header("Location: aboutme.php?uid=".$user."");

}else{
	$file_basename = substr($profile_pic_name, 0, strripos($profile_pic_name, '.'));
$file_ext = substr($profile_pic_name, strripos($profile_pic_name, '.'));
if (((@$_FILES['profilepic']['type']=='image/jpeg') || (@$_FILES['profilepic']['type']=='image/png') || (@$_FILES['profilepic']['type']=='image/jpg') || (@$_FILES['profilepic']['type']=='image/gif')) && (@$_FILES['profilepic']['size'] < 1000000)) {
	if (file_exists("image/profilepic")) {
		//nothing
	}else {
		mkdir("image/profilepic");
	}
	
	
	$filename = strtotime(date('Y-m-d H:i:s')).$file_ext;
	if (file_exists("image/profilepic/".$filename)) {
		$error_message = @$_FILES["profilepic"]["name"]."Already exists";
	}else {
		if(move_uploaded_file(@$_FILES["profilepic"]["tmp_name"], "image/profilepic/".$filename)){
			$photos = $filename;
			if($result = $conn->query("UPDATE user SET phone='$_POST[phone]', address='$_POST[address]', user_pic='$photos' WHERE id='$user'")){
				$delete_file = unlink("image/profilepic/".$pro_pic_db);
				$succs_message = "Informaion Updated!";
			}
			if($utype_db == "teacher"){
				if($result = $conn->query("UPDATE tutor SET inst_name='$_POST[inst_nm]' WHERE t_id='$user'")){
					$succs_message = "Informaion Updated!";
				}
			}
				header("Location: aboutme.php?uid=".$user."");
		}else {
			$error_message = "File can't move!!!";
		}
		//echo "Uploaded and stored in: userdata/profile_pics/$item/".@$_FILES["profilepic"]["name"];
		
		
	}
	}
	else {
		$error_message = "Choose a picture!";
	}
}

}


?>

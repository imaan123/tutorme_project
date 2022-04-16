<?php
include ( "inc/connection.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['userlogin'])) {
	header("Location: index.php");
}
else {
	$user = $_SESSION['userlogin'];
	$result = $con->query("UPDATE user SET last_logout=now(), online='no' WHERE id='$user'");
}
//destroy session
session_destroy();
//unset cookies
setcookie('userlogin', '', 0, "/");

header("Location: index.php");
?>
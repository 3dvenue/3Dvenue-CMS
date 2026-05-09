<?php
/* 3Dvenue-CMS Copyright (c) 2026 yoshihiro Murai Licensed under MIT (https://opensource.org/licenses/MIT)*/
session_start();
$cheked = $_SESSION['ADMIN_CHECK'] ?? "";
if($cheked !=="success" ){
	$_SESSION = array();
	session_destroy();
	header("Location: login.php"); //Redirect to fake top page
}
?>
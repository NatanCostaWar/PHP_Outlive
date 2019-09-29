<?php
session_start();
if (!$_SESSION['username']){
	header("Location: loginpage.php");
	exit();
}
?>
<?php
session_start();
include("connect.php");
if(empty($_POST["username"]) || empty($_POST["password"])){
	header("Location: loginpage.php");
	exit();
}

$user = mysqli_real_escape_string($connection, $_POST["username"]);
$password = mysqli_real_escape_string($connection, $_POST["password"]);

$query = "SELECT id, name FROM user WHERE name = '{$user}' and password = MD5('{$password}')";
$result = mysqli_query($connection, $query);
$row = mysqli_num_rows($result);
echo $row;

if($row == 1){
	$_SESSION['username'] = $user;
	header("Location: userpage.php");
}else{
	header("Location: loginpage.php");
}
?>
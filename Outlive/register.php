<?php
session_start();
include("connect.php");
if(empty($_POST["username"]) || empty($_POST["password"])){
	header("Location: registerpage.php");
	exit();
}

$user = mysqli_real_escape_string($connection, $_POST["username"]);
$password = mysqli_real_escape_string($connection, $_POST["password"]);

#$query = "SELECT id, name FROM user WHERE name = '{$user}' and password = MD5('{$password}')";
$query = "INSERT INTO db_outlive.user (id, name, password) VALUES (NULL, '{$user}', MD5('{$password}'))";
$result = mysqli_query($connection, $query);
if($result){
    header("Location: loginpage.php");
}else{
    header("Location: registerpage.php");
}
?>
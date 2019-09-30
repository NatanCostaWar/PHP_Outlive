<?php
session_start();
include("connect.php");

if(empty($_POST["user"]) || empty($_POST["game"])){
	header("Location: userpage.php");
	exit();
}

$user = $_POST["user"];
$game = $_POST["game"];

$query = "DELETE FROM db_outlive.game WHERE id = $game and user = $user";
$result = mysqli_query($connection, $query) or die(mysql_error());
if($result){
    header("Location: userpage.php");
}else{
    header("Location: userpage.php");
}
?>
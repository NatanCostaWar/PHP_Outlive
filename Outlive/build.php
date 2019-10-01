<?php
session_start();
include("connect.php");
if(empty($_POST["user"]) || empty($_POST["game"])){
	header("Location: gamepage.php?game=$game");
	exit();
}

$user = $_POST["user"];
$game = $_POST["game"];
$build = $_POST["build"];
$space = $_POST["space"];


#Authenticating User:
$query = "SELECT * FROM db_outlive.game WHERE user = $user and id = $game";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

if($row["day"] == NULL){
    header("Location: userpage.php");
	exit();
#IF User is Right:
}else{

	$query = "UPDATE db_outlive.house SET build_spot_$space = '$build' WHERE game = $game and user = $user";
	$result = mysqli_query($connection, $query);

	if($result){
	    header("Location: gamepage.php?game=$game");
	}else{
	    header("Location: index.php");
	}
}
?>
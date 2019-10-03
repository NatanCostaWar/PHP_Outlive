<?php
session_start();
include("connect.php");
if(empty($_POST["user"]) || empty($_POST["game"])){
	header("Location: gamepage.php");
	exit();
}

$user = $_POST["user"];
$game = $_POST["game"];

#Authenticating User:
$query = "SELECT * FROM db_outlive.game WHERE user = $user and id = $game";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

if($row["day"] == NULL){
    header("Location: userpage.php");
	exit();
#IF User is Right:
}else{
	#Updating Day value
	$day = $row["day"]+1;
	$query = "UPDATE db_outlive.game SET day = $day WHERE user = $user and id = $game";
	$result = mysqli_query($connection, $query);

	#PLAYER INFORMATION
	$query = "SELECT * FROM db_outlive.player WHERE game = $game and user = $user";
	$result = mysqli_query($connection, $query);
	$player = mysqli_fetch_array($result);

	#If Explore Option Call Explore Page
	if ($_POST["explore"] == 'true') {
		include("explore.php");
		$query = "UPDATE db_outlive.player SET rest = rest-30 WHERE game = $game";
		$result = mysqli_query($connection, $query);
	}else{
		#Updating player rest value
		$query = "UPDATE db_outlive.player SET rest = rest+40 WHERE game = $game";
		$result = mysqli_query($connection, $query);
	}

	#Updating player Hunger
	$query = "UPDATE db_outlive.player SET hunger = hunger-20 WHERE game = $game";
	$result = mysqli_query($connection, $query);

	#Updating player thirst
	$query = "UPDATE db_outlive.player SET thirst = thirst-25 WHERE game = $game";
	$result = mysqli_query($connection, $query);

	include('playernormalize.php');
	if($result){
	    header("Location: gamepage.php?game=$game");
	}else{
	    header("Location: index.php");
	}
}
?>
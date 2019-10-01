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

	#If Explore Option Call Explore Page
	if ($_POST["explore"] == 'true') {
		include("explore.php");
	}else{
		#Updating player rest value
		$query = "SELECT * FROM db_outlive.player WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$player = mysqli_fetch_array($result);
		$new_rest = ($player["rest"])+40;
		if ($new_rest > 100){
			$new_rest = 100;
		}

		$query = "UPDATE db_outlive.player SET rest = $new_rest WHERE game = $game";
		$result = mysqli_query($connection, $query);

	}



	if($result){
	    header("Location: gamepage.php?game=$game");
	}else{
	    header("Location: index.php");
	}
}
?>
<?php
session_start();
include("connect.php");
if(empty($_POST["user"]) || empty($_POST["game"])){
	header("Location: gamepage.php?game=$game");
	exit();
}

$user = $_POST["user"];
$game = $_POST["game"];
$name = $_POST["name"];
$kit = $_POST["kit"];

#Authenticating User:
$query = "SELECT * FROM db_outlive.game WHERE user = $user and id = $game";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

if($row["day"] == NULL){
    header("Location: userpage.php");
	exit();
#IF User is Right:
}else{
	#INVENTORY INFORMATION
	$query = "SELECT * FROM db_outlive.inventory where game = $game and user = $user";
	$result = mysqli_query($connection, $query);
	$inventory = mysqli_fetch_array($result);

	#PLAYER INFORMATION
	$query = "SELECT * FROM db_outlive.player where game = $game and user = $user";
	$result = mysqli_query($connection, $query);
	$player = mysqli_fetch_array($result);

	$query = "SELECT * FROM db_outlive.house where game = $game and user = $user";
	$result = mysqli_query($connection, $query);
	$house = mysqli_fetch_array($result);

	#See if The player has a chair:
	$query = "SELECT * FROM db_outlive.builds where game = $game and user = $user";
	$builds_result = mysqli_query($connection, $query);
	while ($build_row = mysqli_fetch_assoc($builds_result)){
		if($build_row["name"] == "Chair"){
			$rest_bonus = rand(1, 2);
		}
	}
	if(!isset($rest_bonus)){
		$rest_bonus = 1;
	}


	#if player is too tired:
	if($player["rest"] < (20/$rest_bonus)){
		$_SESSION["msg"] .= "<p>Too tired</p>";
	}else{
		#Making:
		if($name == "homemade_beers"){
		    $query = "UPDATE db_outlive.builds SET hold = 'homemade_beers' WHERE game = $game and user = $user and id = $kit";
		    $update = mysqli_query($connection, $query);

			$query = "UPDATE db_outlive.builds SET time = 2 WHERE game = $game and user = $user and id = $kit";
			$update = mysqli_query($connection, $query);
			
			$quant = $inventory["woods"]-10;
			$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);
			
			$quant = $inventory["cereals"]-5;
			$query = "UPDATE db_outlive.inventory SET cereals = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);

			$quant = $inventory["bottles_of_water"]-3;
			$query = "UPDATE db_outlive.inventory SET bottles_of_water = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);

			
			

		}else{
			$_SESSION["build_error"] = "<p>Not Possible to Make</p>";
			#Updating Player Rest value:
			$query = "UPDATE db_outlive.player SET rest = rest+20/$rest_bonus WHERE game = $game and user = $user";
			$result = mysqli_query($connection, $query);
		}

	}


	header("Location: gamepage.php?game=$game");
}
?>
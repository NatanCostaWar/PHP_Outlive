<?php
session_start();
include("connect.php");
if(empty($_POST["user"]) || empty($_POST["game"]) || empty($_POST["item"])){
	header("Location: gamepage.php");
	exit();
}

$user = $_POST["user"];
$game = $_POST["game"];
$item = $_POST["item"];

#PLAYER INFORMATION
$query = "SELECT * FROM db_outlive.player WHERE game = $game and user = $user";
$result = mysqli_query($connection, $query);
$player = mysqli_fetch_array($result);

#Updating Inventory Item
$query = "UPDATE db_outlive.inventory SET $item = $item-1  WHERE user = $user and game = $game";
$result = mysqli_query($connection, $query);

#DRINK
if($item == 'bottles_of_water'){
	$query = "UPDATE db_outlive.player SET thirst = thirst+10  WHERE user = $user and game = $game";
	$result = mysqli_query($connection, $query);
}
if($item == 'beers'){
	$query = "UPDATE db_outlive.player SET thirst = thirst+15, rest = rest-10  WHERE user = $user and game = $game";
	$result = mysqli_query($connection, $query);
}

#EAT
if($item == 'vegetables'){
	$query = "UPDATE db_outlive.player SET hunger = hunger+15, life = life+3  WHERE user = $user and game = $game";
	$result = mysqli_query($connection, $query);
}
if($item == 'meats'){
	$query = "UPDATE db_outlive.player SET hunger = hunger+20  WHERE user = $user and game = $game";
	$result = mysqli_query($connection, $query);
}
if($item == 'canned_foods'){
	$query = "UPDATE db_outlive.player SET hunger = hunger+25  WHERE user = $user and game = $game";
	$result = mysqli_query($connection, $query);
}

#LIFE
if($item == 'medicines'){
	$query = "UPDATE db_outlive.player SET life = life+35 WHERE user = $user and game = $game";
	$result = mysqli_query($connection, $query);
}
if($item == 'herbs'){
	$query = "UPDATE db_outlive.player SET life = life+15 WHERE user = $user and game = $game";
	$result = mysqli_query($connection, $query);
}

include('playernormalize.php');
if($result){
    header("Location: gamepage.php?game=$game");
}else{
    header("Location: index.php");
}

?>
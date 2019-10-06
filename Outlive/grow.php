<?php
session_start();
include("connect.php");
if(empty($_POST["user"]) || empty($_POST["game"]) || empty($_POST["seed"]) || empty($_POST["farm"])){
	header("Location: gamepage.php?game=$_POST[game]");
	exit();
}

$user = $_POST["user"];
$game = $_POST["game"];
$farm = $_POST["farm"];

if($_POST["seed"] == "vegetable_seeds"){
	$query = "UPDATE db_outlive.inventory SET vegetable_seeds = vegetable_seeds-1 WHERE game = $game and user = $user";
	$result = mysqli_query($connection, $query);

	$query = "UPDATE db_outlive.builds SET hold = 'vegetable_seeds' WHERE game = $game and user = $user and id = $farm";
	$update = mysqli_query($connection, $query);
	$query = "UPDATE db_outlive.builds SET time = 5 WHERE game = $game and user = $user and id = $farm";
	$update = mysqli_query($connection, $query);
	
	

}else if($_POST["seed"] == "herbal_seeds"){
	$query = "UPDATE db_outlive.inventory SET herbal_seeds = herbal_seeds-1 WHERE game = $game and user = $user";
	$result = mysqli_query($connection, $query);

	$query = "UPDATE db_outlive.builds SET hold = 'herbal_seeds' WHERE game = $game and user = $user and id = $farm";
	$update = mysqli_query($connection, $query);
	$query = "UPDATE db_outlive.builds SET time = 5 WHERE game = $game and user = $user and id = $farm";
	$update = mysqli_query($connection, $query);
}

header("Location: gamepage.php?game=$game");

?>
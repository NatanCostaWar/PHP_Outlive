<?php
session_start();
include("connect.php");

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
	if ($_POST["code"] == "levelup") {
		$query = "UPDATE db_outlive.house SET level = 3 WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.house SET spots = 6 WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);
	}
	
	if ($_POST["code"] == "allwin") {
		$query = "UPDATE db_outlive.inventory SET woods = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET scraps = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET nails = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET pipes = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET coffees = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET cigarettes = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET gears = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);


		$query = "UPDATE db_outlive.inventory SET vegetable_seeds = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET vegetables = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET meats = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET canned_foods = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET canned_meals = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET soups = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET tacos = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET beers = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET homemade_beers = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET cereals = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET cereal_seeds = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET bottles_of_water = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET fertilizers = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);


		$query = "UPDATE db_outlive.inventory SET herbal_seeds = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET herbs = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET medicines = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);


		$query = "UPDATE db_outlive.inventory SET guns = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET bullets = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET melee_weapons = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET tools = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
		$query = "UPDATE db_outlive.inventory SET gun_parts = 1000 WHERE game = $game";
		$result = mysqli_query($connection, $query);
	}
	

	if($result){
	    header("Location: gamepage.php?game=$game");
	}else{
	    header("Location: index.php");
	}
}
?>
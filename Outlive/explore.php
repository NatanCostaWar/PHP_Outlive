<?php
include("connect.php");

#Updating player rest value
$query = "SELECT * FROM db_outlive.player WHERE game = $game";
$result = mysqli_query($connection, $query);
$player = mysqli_fetch_array($result);
$new_rest = ($player["rest"])-30;


$query = "UPDATE db_outlive.player SET rest = $new_rest WHERE game = $game";
$result = mysqli_query($connection, $query);

#Search probability Values (100 aways find | 0 never find):
#Basic Stuff:
$find_woods = 80;
$find_scraps = 50;
$find_nails = 60;
$find_pipes = 18;
$find_coffees = 12;
$find_cigarettes = 10;
$find_gears = 8;
#Food and Water:
$find_vegetable_seeds = 0;
$find_vegetables = 0;
$find_meats = 0;
$find_canned_foods = 0;
$find_beers = 0;
$find_bottles_of_water = 0;
#Medicine Stuff
$find_herbal_seeds = 0;
$find_medicines = 0;
$find_herbs = 0;
#Combat Stuff:
$find_guns = 0;
$find_bullets = 0;
$find_melee_weapons = 0;
$find_tools = 0;
$find_gun_parts = 0;


$_SESSION["msg"] = "<p>You Found: </p>";

$find = rand (0, 100);
if($find < $find_woods) {
	$query = "SELECT * FROM db_outlive.inventory WHERE game = $game";
	$result = mysqli_query($connection, $query);
	$inventory = mysqli_fetch_array($result);
	$quant = rand (10, 25);
	$_SESSION["msg"] .= "<p>$quant woods</p>";
	$quant += $inventory["woods"];
	$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
}
$find = rand (0, 100);
if($find < $find_scraps) {
	$query = "SELECT * FROM db_outlive.inventory WHERE game = $game";
	$result = mysqli_query($connection, $query);
	$inventory = mysqli_fetch_array($result);
	$quant = rand (5, 12);
	$_SESSION["msg"] .= "<p>$quant scraps</p>";
	$quant += $inventory["scraps"];
	$query = "UPDATE db_outlive.inventory SET scraps = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
}
$find = rand (0, 100);
if($find < $find_nails) {
	$query = "SELECT * FROM db_outlive.inventory WHERE game = $game";
	$result = mysqli_query($connection, $query);
	$inventory = mysqli_fetch_array($result);
	$quant = rand (5, 12);
	$_SESSION["msg"] .= "<p>$quant nails</p>";
	$quant += $inventory["nails"];
	$query = "UPDATE db_outlive.inventory SET nails = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
}
$find = rand (0, 100);
if($find < $find_pipes) {
	$query = "SELECT * FROM db_outlive.inventory WHERE game = $game";
	$result = mysqli_query($connection, $query);
	$inventory = mysqli_fetch_array($result);
	$quant = rand (2, 6);
	$_SESSION["msg"] .= "<p>$quant pipes</p>";
	$quant += $inventory["pipes"];
	$query = "UPDATE db_outlive.inventory SET pipes = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
}
$find = rand (0, 100);
if($find < $find_coffees) {
	$query = "SELECT * FROM db_outlive.inventory WHERE game = $game";
	$result = mysqli_query($connection, $query);
	$inventory = mysqli_fetch_array($result);
	$quant = rand (5, 10);
	$_SESSION["msg"] .= "<p>$quant coffees</p>";
	$quant += $inventory["coffees"];
	$query = "UPDATE db_outlive.inventory SET coffees = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
}
$find = rand (0, 100);
if($find < $find_cigarettes) {
	$query = "SELECT * FROM db_outlive.inventory WHERE game = $game";
	$result = mysqli_query($connection, $query);
	$inventory = mysqli_fetch_array($result);
	$quant = rand (3, 8);
	$_SESSION["msg"] .= "<p>$quant cigarettes</p>";
	$quant += $inventory["cigarettes"];
	$query = "UPDATE db_outlive.inventory SET cigarettes = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
}
$find = rand (0, 100);
if($find < $find_gears) {
	$query = "SELECT * FROM db_outlive.inventory WHERE game = $game";
	$result = mysqli_query($connection, $query);
	$inventory = mysqli_fetch_array($result);
	$quant = rand (1, 5);
	$_SESSION["msg"] .= "<p>$quant gears</p>";
	$quant += $inventory["gears"];
	$query = "UPDATE db_outlive.inventory SET gears = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
}

?>
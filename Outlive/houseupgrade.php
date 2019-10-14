<?php
session_start();
include("connect.php");
if(empty($_POST["user"]) || empty($_POST["game"])){
	header("Location: gamepage.php?game=$_POST[game]");
	exit();
}

$user = $_POST["user"];
$game = $_POST["game"];

#INVENTORY INFORMATION
$query = "SELECT * FROM db_outlive.inventory where game = $game and user = $user";
$result = mysqli_query($connection, $query);
$inventory = mysqli_fetch_array($result);

#HOUSE INFORMATION
$query = "SELECT * FROM db_outlive.house where game = $game and user = $user";
$result = mysqli_query($connection, $query);
$house = mysqli_fetch_array($result);

echo $house["level"];

if($house["level"] == 0 and $inventory["tools"] >= 1 and $inventory["woods"] >= 50 and $inventory["scraps"] >= 40 and $inventory["pipes"] >= 20 and $inventory["gears"] >= 5){
	$query = "UPDATE db_outlive.house SET level = level+1 WHERE game = $game and user = $user";
	$result = mysqli_query($connection, $query);

	$query = "UPDATE db_outlive.house SET spots = spots+1 WHERE game = $game and user = $user";
	$result = mysqli_query($connection, $query);

	$quant = $inventory["tools"]-1;
	$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
	
	$quant = $inventory["woods"]-50;
	$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
	
	$quant = $inventory["scraps"]-40;
	$query = "UPDATE db_outlive.inventory SET scraps = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);

	$quant = $inventory["pipes"]-20;
	$query = "UPDATE db_outlive.inventory SET pipes = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);

	$quant = $inventory["gears"]-5;
	$query = "UPDATE db_outlive.inventory SET gears = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
}else if($house["level"] == 1 and $inventory["tools"] >= 1 and $inventory["woods"] >= 100 and $inventory["scraps"] >= 70 and $inventory["pipes"] >= 30 and $inventory["gears"] >= 8){
	$query = "UPDATE db_outlive.house SET level = level+1 WHERE game = $game and user = $user";
	$result = mysqli_query($connection, $query);

	$query = "UPDATE db_outlive.house SET spots = spots+1 WHERE game = $game and user = $user";
	$result = mysqli_query($connection, $query);

	$quant = $inventory["tools"]-1;
	$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
	
	$quant = $inventory["woods"]-100;
	$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
	
	$quant = $inventory["scraps"]-70;
	$query = "UPDATE db_outlive.inventory SET scraps = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);

	$quant = $inventory["pipes"]-20;
	$query = "UPDATE db_outlive.inventory SET pipes = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);

	$quant = $inventory["gears"]-8;
	$query = "UPDATE db_outlive.inventory SET gears = $quant WHERE game = $game";
	$result = mysqli_query($connection, $query);
}else{
	$_SESSION["msg"] .= '
	<form action="manual.php#house" method="post">
    	<input type="hidden" name="game" value=' . $game["id"] .'>
		<input type="hidden" name="user" value=' . $user["id"] . '>
		<p>Not Possible to Upgrade, See the	
			<button type="submit" class="btn border" style="color:#f1f0ea;background-color:#11121a;padding:0px;">
	        	Manual
			</button>
		</p>
    </form>';
}

		
	header("Location: gamepage.php?game=$game");
?>
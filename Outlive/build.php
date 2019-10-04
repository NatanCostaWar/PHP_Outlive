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
	$query = "SELECT * FROM db_outlive.inventory where game = $game and user = $user";
	$result = mysqli_query($connection, $query);
	$inventory = mysqli_fetch_array($result);

	if($build == "stove" and $inventory["tools"] >= 1 and $inventory["woods"] >= 15 and $inventory["scraps"] >= 30 and $inventory["pipes"] >= 4){
		$query = "UPDATE db_outlive.house SET build_spot_$space = '$build' WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["woods"]-15;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["scraps"]-30;
		$query = "UPDATE db_outlive.inventory SET scraps = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["pipes"]-4;
		$query = "UPDATE db_outlive.inventory SET pipes = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

	}else if($build == "bed" and $inventory["tools"] >= 1 and $inventory["woods"] >= 40 and $inventory["nails"] >= 20){
		$query = "UPDATE db_outlive.house SET build_spot_$space = '$build' WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["woods"]-40;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["nails"]-20;
		$query = "UPDATE db_outlive.inventory SET nails = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

	}else if($build == "workbench" and $inventory["tools"] >= 1 and $inventory["woods"] >= 50 and $inventory["nails"] >= 15 and $inventory["scrap"] >= 10){
		$query = "UPDATE db_outlive.house SET build_spot_$space = '$build' WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["woods"]-50;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["nails"]-15;
		$query = "UPDATE db_outlive.inventory SET nails = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["scrap"]-10;
		$query = "UPDATE db_outlive.inventory SET scrap = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

	}else if($build == "chair" and $inventory["tools"] >= 1 and $inventory["woods"] >= 20 and $inventory["nails"] >= 10){
		$query = "UPDATE db_outlive.house SET build_spot_$space = '$build' WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["woods"]-20;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["nails"]-10;
		$query = "UPDATE db_outlive.inventory SET nails = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

	}else if($build == "watercollector" and $inventory["tools"] >= 1 and $inventory["woods"] >= 12 and $inventory["scraps"] >= 15 and $inventory["pipes"] >= 10 ){
		$query = "UPDATE db_outlive.house SET build_spot_$space = '$build' WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["woods"]-12;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["scraps"]-15;
		$query = "UPDATE db_outlive.inventory SET scrap = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["pipes"]-10;
		$query = "UPDATE db_outlive.inventory SET pipes = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

	}else if($build == "farm" and $inventory["tools"] >= 1 and $inventory["woods"] >= 40 and $inventory["pipes"] >= 4 and $inventory["nails"] >= 15 and $inventory["fertilizers"] >= 1){
		$query = "UPDATE db_outlive.house SET build_spot_$space = '$build' WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["woods"]-40;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["nails"]-15;
		$query = "UPDATE db_outlive.inventory SET nails = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["pipes"]-4;
		$query = "UPDATE db_outlive.inventory SET pipes = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["fertilizers"]-1;
		$query = "UPDATE db_outlive.inventory SET fertilizers = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
	}else{
		$_SESSION["build_error"] = "<p>Not Possible to Build</p>";
	}

	#$query = "UPDATE db_outlive.house SET build_spot_$space = '$build' WHERE game = $game and user = $user";
	#$result = mysqli_query($connection, $query);

	#if($result){
	    header("Location: gamepage.php?game=$game");
	#}else{
	#    header("Location: index.php");
	#}
}
?>
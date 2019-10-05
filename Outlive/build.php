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
	#INVENTORY INFORMATION
	$query = "SELECT * FROM db_outlive.inventory where game = $game and user = $user";
	$result = mysqli_query($connection, $query);
	$inventory = mysqli_fetch_array($result);
	

	if($build == "Stove" and $inventory["tools"] >= 1 and $inventory["woods"] >= 15 and $inventory["scraps"] >= 30 and $inventory["pipes"] >= 4){
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

	}else if($build == "Bed" and $inventory["tools"] >= 1 and $inventory["woods"] >= 40 and $inventory["nails"] >= 20){
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

	}else if($build == "Workbench" and $inventory["tools"] >= 1 and $inventory["woods"] >= 50 and $inventory["nails"] >= 15 and $inventory["scraps"] >= 10){
		$query = "UPDATE db_outlive.house SET build_spot_$space = '$build' WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["woods"]-50;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["nails"]-15;
		$query = "UPDATE db_outlive.inventory SET nails = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["scraps"]-10;
		$query = "UPDATE db_outlive.inventory SET scraps = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

	}else if($build == "Chair" and $inventory["tools"] >= 1 and $inventory["woods"] >= 20 and $inventory["nails"] >= 10){
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

	}else if($build == "Water Collector" and $inventory["tools"] >= 1 and $inventory["woods"] >= 12 and $inventory["scraps"] >= 15 and $inventory["pipes"] >= 10 ){
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

	}else if($build == "Farm" and $inventory["tools"] >= 1 and $inventory["woods"] >= 40 and $inventory["pipes"] >= 4 and $inventory["nails"] >= 15 and $inventory["fertilizers"] >= 1){
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

	#HOUSE INFORMATION
	$query = "SELECT * FROM db_outlive.house where game = $game and user = $user";
	$result = mysqli_query($connection, $query);
	$house = mysqli_fetch_array($result);
	
	#Builds Amount = 0:
	$query = "UPDATE db_outlive.builds SET amount = 0 WHERE game = $game and user = $user";
	$result = mysqli_query($connection, $query);
	#Updating Builds Amount:
	for ($i = 1; $i <= (3+$house["level"]); $i++){
		$obj =  $house["build_spot_$i"];
		$query = "UPDATE db_outlive.builds SET amount = amount+1 WHERE game = $game and user = $user and name = '$obj'";
		$result = mysqli_query($connection, $query);
	}


	header("Location: gamepage.php?game=$game");
}
?>